<?php

namespace Database\Seeders;

use App\Models\CostFormulaItem;
use App\Models\CostIngredient;
use App\Models\CostPresentation;
use App\Models\CostProductType;
use App\Models\CostSetting;
use Illuminate\Database\Seeder;

class CostBudgetSeeder extends Seeder
{
    public function run()
    {
        CostSetting::updateOrCreate(
            ['id' => 1],
            [
                'monthly_salary' => 2200000,
                'working_days_per_month' => 30,
                'working_hours_per_day' => 8,
            ]
        );

        $ingredients = collect([
            ['name' => 'CACAO', 'cost_per_kg' => 30000],
            ['name' => 'PANELA', 'cost_per_kg' => 4000],
            ['name' => 'CLAVOS', 'cost_per_kg' => 112000],
            ['name' => 'CANELA', 'cost_per_kg' => 112000],
            ['name' => 'NUEZ MOSCADA', 'cost_per_kg' => 112000],
        ])->mapWithKeys(function ($ingredient) {
            $model = CostIngredient::updateOrCreate(
                ['name' => $ingredient['name']],
                [
                    'cost_per_kg' => $ingredient['cost_per_kg'],
                    'unit' => 'kg',
                    'state' => 1,
                ]
            );

            return [$ingredient['name'] => $model];
        });

        collect([
            ['reference' => '1', 'name' => 'Bolsa 125 g', 'grams' => 125, 'package_cost' => 650, 'label_cost' => 800, 'sort_order' => 1],
            ['reference' => '2', 'name' => 'Bolsa 250 g', 'grams' => 250, 'package_cost' => 1224, 'label_cost' => 800, 'sort_order' => 2],
            ['reference' => '3', 'name' => 'Bolsa 500 g', 'grams' => 500, 'package_cost' => 1370, 'label_cost' => 800, 'sort_order' => 3],
            ['reference' => '4', 'name' => 'Bolsa 1000 g', 'grams' => 1000, 'package_cost' => 3270, 'label_cost' => 800, 'sort_order' => 4],
        ])->each(function ($presentation) {
            CostPresentation::updateOrCreate(
                ['reference' => $presentation['reference']],
                $presentation + ['state' => 1]
            );
        });

        $productTypes = collect([
            [
                'name' => 'CACAO PURO',
                'slug' => 'cacao-puro',
                'description' => 'Configuracion inicial cargada desde el Excel de costos.',
                'base_output_grams' => 7000,
                'base_production_hours' => 7,
                'wholesale_multiplier' => 2.25,
                'retail_multiplier' => 3,
                'discount_percentage' => 10,
                'formula' => [
                    ['ingredient' => 'CACAO', 'grams' => 8750, 'sort_order' => 1],
                ],
            ],
            [
                'name' => 'CHOCOLATE DE MESA ENDULZADO',
                'slug' => 'chocolate-de-mesa-endulzado',
                'description' => 'Configuracion inicial basada en la hoja ENDULZADO del Excel.',
                'base_output_grams' => 14000,
                'base_production_hours' => 7,
                'wholesale_multiplier' => 2.15,
                'retail_multiplier' => 3,
                'discount_percentage' => 10,
                'formula' => [
                    ['ingredient' => 'CACAO', 'grams' => 8750, 'sort_order' => 1],
                    ['ingredient' => 'PANELA', 'grams' => 7000, 'sort_order' => 2],
                ],
            ],
            [
                'name' => 'CHOCOLATE DE MESA ALIÑADO',
                'slug' => 'chocolate-de-mesa-alinado',
                'description' => 'Configuracion inicial basada en la hoja ALIÑADO del Excel.',
                'base_output_grams' => 15000,
                'base_production_hours' => 7,
                'wholesale_multiplier' => 2.15,
                'retail_multiplier' => 3,
                'discount_percentage' => 10,
                'formula' => [
                    ['ingredient' => 'CACAO', 'grams' => 7000, 'sort_order' => 1],
                    ['ingredient' => 'CLAVOS', 'grams' => 40, 'sort_order' => 2],
                    ['ingredient' => 'CANELA', 'grams' => 40, 'sort_order' => 3],
                    ['ingredient' => 'NUEZ MOSCADA', 'grams' => 40, 'sort_order' => 4],
                    ['ingredient' => 'PANELA', 'grams' => 9000, 'sort_order' => 5],
                ],
            ],
        ]);

        $productTypes->each(function ($productTypeData) use ($ingredients) {
            $productType = CostProductType::updateOrCreate(
                ['slug' => $productTypeData['slug']],
                [
                    'name' => $productTypeData['name'],
                    'description' => $productTypeData['description'],
                    'base_output_grams' => $productTypeData['base_output_grams'],
                    'base_production_hours' => $productTypeData['base_production_hours'],
                    'wholesale_multiplier' => $productTypeData['wholesale_multiplier'],
                    'retail_multiplier' => $productTypeData['retail_multiplier'],
                    'discount_percentage' => $productTypeData['discount_percentage'],
                    'state' => 1,
                ]
            );

            foreach ($productTypeData['formula'] as $formula) {
                CostFormulaItem::updateOrCreate(
                    [
                        'cost_product_type_id' => $productType->id,
                        'cost_ingredient_id' => $ingredients[$formula['ingredient']]->id,
                    ],
                    [
                        'grams' => $formula['grams'],
                        'sort_order' => $formula['sort_order'],
                    ]
                );
            }
        });
    }
}
