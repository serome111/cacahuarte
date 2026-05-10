<?php

namespace App\Services;

use App\Models\CostPresentation;
use App\Models\CostProductType;
use App\Models\CostSetting;
use Illuminate\Support\Collection;

class CostBudgetService
{
    public function simulate(
        CostProductType $productType,
        CostSetting $settings,
        Collection $presentations,
        float $targetOutputKg,
        array $quantities = []
    ): array {
        $targetOutputGrams = $targetOutputKg * 1000;
        $baseOutputGrams = max((float) $productType->base_output_grams, 1);
        $scaleFactor = $targetOutputGrams / $baseOutputGrams;

        $hourlyLaborCost = $this->calculateHourlyLaborCost($settings);
        $totalLaborCost = $hourlyLaborCost * (float) $productType->base_production_hours * $scaleFactor;

        $ingredientRows = $productType->formulaItems->map(function ($item) use ($scaleFactor) {
            $requiredGrams = (float) $item->grams * $scaleFactor;
            $costPerGram = ((float) $item->ingredient->cost_per_kg) / 1000;
            $totalCost = $requiredGrams * $costPerGram;

            return [
                'id' => $item->id,
                'ingredient' => $item->ingredient->name,
                'base_grams' => (float) $item->grams,
                'required_grams' => $requiredGrams,
                'required_kg' => $requiredGrams / 1000,
                'cost_per_kg' => (float) $item->ingredient->cost_per_kg,
                'cost_per_gram' => $costPerGram,
                'total_cost' => $totalCost,
            ];
        })->values();

        $totalInputGrams = $ingredientRows->sum('required_grams');
        $totalIngredientCost = $ingredientRows->sum('total_cost');
        $yieldLossGrams = max($totalInputGrams - $targetOutputGrams, 0);
        $yieldLossPercent = $totalInputGrams > 0 ? ($yieldLossGrams / $totalInputGrams) * 100 : 0;
        $ingredientCostPerFinishedGram = $targetOutputGrams > 0 ? $totalIngredientCost / $targetOutputGrams : 0;
        $laborCostPerFinishedGram = $targetOutputGrams > 0 ? $totalLaborCost / $targetOutputGrams : 0;

        $presentationRows = $presentations->map(function (CostPresentation $presentation) use (
            $productType,
            $quantities,
            $targetOutputGrams,
            $ingredientCostPerFinishedGram,
            $laborCostPerFinishedGram
        ) {
            $quantity = isset($quantities[$presentation->id]) ? (float) $quantities[$presentation->id] : 0;
            $ingredientCost = (float) $presentation->grams * $ingredientCostPerFinishedGram;
            $laborCost = (float) $presentation->grams * $laborCostPerFinishedGram;
            $netCost = $ingredientCost + $laborCost + (float) $presentation->package_cost + (float) $presentation->label_cost;
            $wholesalePrice = $netCost * (float) $productType->wholesale_multiplier;
            $retailPrice = $netCost * (float) $productType->retail_multiplier;
            $discountAmount = $retailPrice * ((float) $productType->discount_percentage / 100);
            $allocatedGrams = (float) $presentation->grams * $quantity;
            $maxUnitsIfOnlyThisPresentation = $presentation->grams > 0
                ? floor($targetOutputGrams / (float) $presentation->grams)
                : 0;

            return [
                'id' => $presentation->id,
                'reference' => $presentation->reference,
                'name' => $presentation->name,
                'grams' => (float) $presentation->grams,
                'quantity' => $quantity,
                'allocated_grams' => $allocatedGrams,
                'max_units_if_only_this_presentation' => $maxUnitsIfOnlyThisPresentation,
                'ingredient_cost' => $ingredientCost,
                'labor_cost' => $laborCost,
                'package_cost' => (float) $presentation->package_cost,
                'label_cost' => (float) $presentation->label_cost,
                'net_cost' => $netCost,
                'wholesale_price' => $wholesalePrice,
                'retail_price' => $retailPrice,
                'discount_amount' => $discountAmount,
                'total_quote_cost' => $netCost * $quantity,
                'total_quote_wholesale' => $wholesalePrice * $quantity,
                'total_quote_retail' => $retailPrice * $quantity,
            ];
        })->values();

        $packagedGrams = $presentationRows->sum('allocated_grams');
        $remainingPackableGrams = max($targetOutputGrams - $packagedGrams, 0);
        $overAllocatedGrams = max($packagedGrams - $targetOutputGrams, 0);
        $packagingCoveragePercent = $targetOutputGrams > 0
            ? ($packagedGrams / $targetOutputGrams) * 100
            : 0;

        return [
            'summary' => [
                'product_type' => $productType->name,
                'target_output_kg' => $targetOutputKg,
                'target_output_grams' => $targetOutputGrams,
                'base_output_grams' => $baseOutputGrams,
                'scale_factor' => $scaleFactor,
                'hourly_labor_cost' => $hourlyLaborCost,
                'total_labor_cost' => $totalLaborCost,
                'total_input_grams' => $totalInputGrams,
                'yield_loss_grams' => $yieldLossGrams,
                'yield_loss_percent' => $yieldLossPercent,
                'total_ingredient_cost' => $totalIngredientCost,
                'ingredient_cost_per_finished_gram' => $ingredientCostPerFinishedGram,
                'labor_cost_per_finished_gram' => $laborCostPerFinishedGram,
                'packaged_grams' => $packagedGrams,
                'remaining_packable_grams' => $remainingPackableGrams,
                'over_allocated_grams' => $overAllocatedGrams,
                'packaging_coverage_percent' => $packagingCoveragePercent,
                'is_packaging_valid' => $packagedGrams <= $targetOutputGrams,
            ],
            'ingredients' => $ingredientRows->all(),
            'presentations' => $presentationRows->all(),
            'quote_totals' => [
                'units' => $presentationRows->sum('quantity'),
                'cost' => $presentationRows->sum('total_quote_cost'),
                'wholesale' => $presentationRows->sum('total_quote_wholesale'),
                'retail' => $presentationRows->sum('total_quote_retail'),
            ],
        ];
    }

    public function buildPriceList(
        Collection $productTypes,
        CostSetting $settings,
        Collection $presentations
    ): array {
        return $productTypes->map(function (CostProductType $productType) use ($settings, $presentations) {
            $simulation = $this->simulate(
                $productType,
                $settings,
                $presentations,
                ((float) $productType->base_output_grams) / 1000
            );

            return [
                'product_type_id' => $productType->id,
                'product_type_name' => $productType->name,
                'base_output_grams' => (float) $productType->base_output_grams,
                'base_production_hours' => (float) $productType->base_production_hours,
                'rows' => $simulation['presentations'],
            ];
        })->all();
    }

    public function calculateHourlyLaborCost(CostSetting $settings): float
    {
        $workingDays = max((int) $settings->working_days_per_month, 1);
        $workingHours = max((float) $settings->working_hours_per_day, 0.1);

        return ((float) $settings->monthly_salary) / $workingDays / $workingHours;
    }
}
