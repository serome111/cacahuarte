<?php

namespace Tests\Unit;

use App\Models\CostFormulaItem;
use App\Models\CostIngredient;
use App\Models\CostPresentation;
use App\Models\CostProductType;
use App\Models\CostSetting;
use App\Services\CostBudgetService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CostBudgetServiceTest extends TestCase
{
    public function test_it_calculates_required_ingredients_and_unit_costs()
    {
        $productType = new CostProductType([
            'name' => 'CACAO PURO',
            'base_output_grams' => 7000,
            'base_production_hours' => 7,
            'wholesale_multiplier' => 2.25,
            'retail_multiplier' => 3,
            'discount_percentage' => 10,
        ]);

        $settings = new CostSetting([
            'monthly_salary' => 2200000,
            'working_days_per_month' => 30,
            'working_hours_per_day' => 8,
        ]);

        $ingredient = new CostIngredient([
            'name' => 'CACAO',
            'cost_per_kg' => 30000,
        ]);

        $formulaItem = new CostFormulaItem([
            'grams' => 8750,
            'sort_order' => 1,
        ]);
        $formulaItem->setRelation('ingredient', $ingredient);

        $productType->setRelation('formulaItems', new Collection([$formulaItem]));

        $presentation = new CostPresentation([
            'reference' => '1',
            'name' => 'Bolsa 125 g',
            'grams' => 125,
            'package_cost' => 650,
            'label_cost' => 800,
        ]);
        $presentation->id = 1;

        $presentations = new Collection([$presentation]);

        $service = new CostBudgetService();
        $result = $service->simulate($productType, $settings, $presentations, 7, [1 => 10]);

        $this->assertEquals(8750.0, $result['summary']['total_input_grams']);
        $this->assertEquals(262500.0, $result['summary']['total_ingredient_cost']);
        $this->assertEquals(1750.0, $result['summary']['yield_loss_grams']);
        $this->assertEquals(10.0, $result['quote_totals']['units']);
        $this->assertTrue($result['summary']['is_packaging_valid']);
        $this->assertEquals(1250.0, $result['summary']['packaged_grams']);
        $this->assertEquals(5750.0, $result['summary']['remaining_packable_grams']);
        $this->assertEquals(56.0, $result['presentations'][0]['max_units_if_only_this_presentation']);
        $this->assertEquals(4687.5, round($result['presentations'][0]['ingredient_cost'], 1));
        $this->assertEquals(7283.33, round($result['presentations'][0]['net_cost'], 2));
    }

    public function test_it_builds_a_price_list_using_the_base_output_of_each_product()
    {
        $productType = new CostProductType([
            'id' => 15,
            'name' => 'CHOCOLATE DE MESA ENDULZADO',
            'base_output_grams' => 14000,
            'base_production_hours' => 7,
            'wholesale_multiplier' => 2.15,
            'retail_multiplier' => 3,
            'discount_percentage' => 10,
        ]);

        $settings = new CostSetting([
            'monthly_salary' => 2200000,
            'working_days_per_month' => 30,
            'working_hours_per_day' => 8,
        ]);

        $cacao = new CostIngredient([
            'name' => 'CACAO',
            'cost_per_kg' => 30000,
        ]);

        $panela = new CostIngredient([
            'name' => 'PANELA',
            'cost_per_kg' => 4000,
        ]);

        $formulaItems = new Collection([
            tap(new CostFormulaItem(['grams' => 8750, 'sort_order' => 1]), function ($item) use ($cacao) {
                $item->setRelation('ingredient', $cacao);
            }),
            tap(new CostFormulaItem(['grams' => 7000, 'sort_order' => 2]), function ($item) use ($panela) {
                $item->setRelation('ingredient', $panela);
            }),
        ]);

        $productType->setRelation('formulaItems', $formulaItems);

        $presentation125 = new CostPresentation([
            'reference' => '1',
            'name' => 'Bolsa 125 g',
            'grams' => 125,
            'package_cost' => 650,
            'label_cost' => 800,
            'state' => 1,
        ]);
        $presentation125->id = 1;

        $presentation250 = new CostPresentation([
            'reference' => '2',
            'name' => 'Bolsa 250 g',
            'grams' => 250,
            'package_cost' => 1224,
            'label_cost' => 800,
            'state' => 1,
        ]);
        $presentation250->id = 2;

        $service = new CostBudgetService();
        $priceList = $service->buildPriceList(
            new Collection([$productType]),
            $settings,
            new Collection([$presentation125, $presentation250])
        );

        $this->assertCount(1, $priceList);
        $this->assertEquals('CHOCOLATE DE MESA ENDULZADO', $priceList[0]['product_type_name']);
        $this->assertEquals(14000.0, $priceList[0]['base_output_grams']);
        $this->assertCount(2, $priceList[0]['rows']);
        $this->assertEquals(4616.67, round($priceList[0]['rows'][0]['net_cost'], 2));
        $this->assertEquals(17968.27, round($priceList[0]['rows'][1]['wholesale_price'], 2));
    }

    public function test_it_marks_packaging_as_invalid_when_requested_bags_exceed_production()
    {
        $productType = new CostProductType([
            'name' => 'CACAO PURO',
            'base_output_grams' => 7000,
            'base_production_hours' => 7,
            'wholesale_multiplier' => 2.25,
            'retail_multiplier' => 3,
            'discount_percentage' => 10,
        ]);

        $settings = new CostSetting([
            'monthly_salary' => 2200000,
            'working_days_per_month' => 30,
            'working_hours_per_day' => 8,
        ]);

        $ingredient = new CostIngredient([
            'name' => 'CACAO',
            'cost_per_kg' => 30000,
        ]);

        $formulaItem = new CostFormulaItem([
            'grams' => 8750,
            'sort_order' => 1,
        ]);
        $formulaItem->setRelation('ingredient', $ingredient);
        $productType->setRelation('formulaItems', new Collection([$formulaItem]));

        $presentation125 = new CostPresentation([
            'reference' => '1',
            'name' => 'Bolsa 125 g',
            'grams' => 125,
            'package_cost' => 650,
            'label_cost' => 800,
        ]);
        $presentation125->id = 1;

        $presentation250 = new CostPresentation([
            'reference' => '2',
            'name' => 'Bolsa 250 g',
            'grams' => 250,
            'package_cost' => 1224,
            'label_cost' => 800,
        ]);
        $presentation250->id = 2;

        $presentation500 = new CostPresentation([
            'reference' => '3',
            'name' => 'Bolsa 500 g',
            'grams' => 500,
            'package_cost' => 1370,
            'label_cost' => 800,
        ]);
        $presentation500->id = 3;

        $presentation1000 = new CostPresentation([
            'reference' => '4',
            'name' => 'Bolsa 1000 g',
            'grams' => 1000,
            'package_cost' => 3270,
            'label_cost' => 800,
        ]);
        $presentation1000->id = 4;

        $service = new CostBudgetService();
        $result = $service->simulate(
            $productType,
            $settings,
            new Collection([$presentation125, $presentation250, $presentation500, $presentation1000]),
            10,
            [1 => 100, 2 => 100, 3 => 100, 4 => 100]
        );

        $this->assertFalse($result['summary']['is_packaging_valid']);
        $this->assertEquals(187500.0, $result['summary']['packaged_grams']);
        $this->assertEquals(177500.0, $result['summary']['over_allocated_grams']);
    }
}
