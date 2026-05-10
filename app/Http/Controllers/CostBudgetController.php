<?php

namespace App\Http\Controllers;

use App\Models\CostFormulaItem;
use App\Models\CostIngredient;
use App\Models\CostPresentation;
use App\Models\CostProductType;
use App\Models\CostSetting;
use App\Services\CostBudgetService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CostBudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return $this->renderIndex(
            $request->input('tab', 'simulator'),
            null,
            (int) $request->input('product_type', 0)
        );
    }

    public function storeProductType(Request $request)
    {
        $validated = $this->validateProductType($request);
        $validated['slug'] = $this->uniqueSlug($validated['name']);

        CostProductType::create($validated);

        return redirect()
            ->route('costs.index', ['tab' => 'products'])
            ->with('status', 'Tipo de producto creado con exito.');
    }

    public function updateProductType(Request $request, CostProductType $productType)
    {
        $validated = $this->validateProductType($request, $productType);
        $validated['slug'] = $this->uniqueSlug($validated['name'], $productType->id);

        $productType->update($validated);

        return redirect()
            ->route('costs.index', ['tab' => 'products'])
            ->with('status', 'Tipo de producto actualizado con exito.');
    }

    public function storeIngredient(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cost_per_kg' => ['required', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:50'],
            'state' => ['nullable', 'integer', 'in:0,1'],
        ]);

        CostIngredient::create([
            'name' => $validated['name'],
            'cost_per_kg' => $validated['cost_per_kg'],
            'unit' => $validated['unit'] ?? 'kg',
            'state' => $validated['state'] ?? 1,
        ]);

        return redirect()
            ->route('costs.index', ['tab' => 'ingredients'])
            ->with('status', 'Insumo creado con exito.');
    }

    public function updateIngredient(Request $request, CostIngredient $ingredient)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cost_per_kg' => ['required', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:50'],
            'state' => ['nullable', 'integer', 'in:0,1'],
        ]);

        $ingredient->update([
            'name' => $validated['name'],
            'cost_per_kg' => $validated['cost_per_kg'],
            'unit' => $validated['unit'] ?? 'kg',
            'state' => $validated['state'] ?? 1,
        ]);

        return redirect()
            ->route('costs.index', ['tab' => 'ingredients'])
            ->with('status', 'Insumo actualizado con exito.');
    }

    public function storePresentation(Request $request)
    {
        $validated = $request->validate([
            'reference' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'grams' => ['required', 'numeric', 'min:0.01'],
            'package_cost' => ['required', 'numeric', 'min:0'],
            'label_cost' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'state' => ['nullable', 'integer', 'in:0,1'],
        ]);

        CostPresentation::create([
            'reference' => $validated['reference'],
            'name' => $validated['name'],
            'grams' => $validated['grams'],
            'package_cost' => $validated['package_cost'],
            'label_cost' => $validated['label_cost'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'state' => $validated['state'] ?? 1,
        ]);

        return redirect()
            ->route('costs.index', ['tab' => 'presentations'])
            ->with('status', 'Presentacion creada con exito.');
    }

    public function updatePresentation(Request $request, CostPresentation $presentation)
    {
        $validated = $request->validate([
            'reference' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'grams' => ['required', 'numeric', 'min:0.01'],
            'package_cost' => ['required', 'numeric', 'min:0'],
            'label_cost' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'state' => ['nullable', 'integer', 'in:0,1'],
        ]);

        $presentation->update([
            'reference' => $validated['reference'],
            'name' => $validated['name'],
            'grams' => $validated['grams'],
            'package_cost' => $validated['package_cost'],
            'label_cost' => $validated['label_cost'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'state' => $validated['state'] ?? 1,
        ]);

        return redirect()
            ->route('costs.index', ['tab' => 'presentations'])
            ->with('status', 'Presentacion actualizada con exito.');
    }

    public function storeFormulaItem(Request $request)
    {
        $validated = $request->validate([
            'cost_product_type_id' => ['required', 'exists:cost_product_types,id'],
            'cost_ingredient_id' => [
                'required',
                'exists:cost_ingredients,id',
                Rule::unique('cost_formula_items')->where(function ($query) use ($request) {
                    return $query
                        ->where('cost_product_type_id', $request->cost_product_type_id)
                        ->where('cost_ingredient_id', $request->cost_ingredient_id);
                }),
            ],
            'grams' => ['required', 'numeric', 'min:0.01'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        CostFormulaItem::create([
            'cost_product_type_id' => $validated['cost_product_type_id'],
            'cost_ingredient_id' => $validated['cost_ingredient_id'],
            'grams' => $validated['grams'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('costs.index', ['tab' => 'formulas'])
            ->with('status', 'Ingrediente agregado a la formulacion.');
    }

    public function updateFormulaItem(Request $request, CostFormulaItem $formulaItem)
    {
        $validated = $request->validate([
            'grams' => ['required', 'numeric', 'min:0.01'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $formulaItem->update([
            'grams' => $validated['grams'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('costs.index', ['tab' => 'formulas'])
            ->with('status', 'Formulacion actualizada con exito.');
    }

    public function destroyFormulaItem(CostFormulaItem $formulaItem)
    {
        $formulaItem->delete();

        return redirect()
            ->route('costs.index', ['tab' => 'formulas'])
            ->with('status', 'Ingrediente removido de la formulacion.');
    }

    public function simulate(Request $request, CostBudgetService $service)
    {
        $validated = $request->validate([
            'cost_product_type_id' => ['required', 'exists:cost_product_types,id'],
            'target_output_kg' => ['required', 'numeric', 'min:0.01'],
            'quantities' => ['nullable', 'array'],
            'quantities.*' => ['nullable', 'numeric', 'min:0'],
        ]);

        $productType = CostProductType::with('formulaItems.ingredient')
            ->findOrFail($validated['cost_product_type_id']);
        $settings = $this->getCostSettings();
        $presentations = CostPresentation::active()->ordered()->get();
        $targetOutputGrams = (float) $validated['target_output_kg'] * 1000;
        $quantities = $validated['quantities'] ?? [];
        $packagedGrams = $presentations->sum(function (CostPresentation $presentation) use ($quantities) {
            return ((float) ($quantities[$presentation->id] ?? 0)) * (float) $presentation->grams;
        });

        if ($packagedGrams > $targetOutputGrams) {
            $excessKg = ($packagedGrams - $targetOutputGrams) / 1000;

            throw ValidationException::withMessages([
                'quantities' => [
                    'La combinacion de bolsas excede la produccion objetivo por '
                    . number_format($excessKg, 2, ',', '.')
                    . ' kg. Ajusta las cantidades para que el empaque no supere la produccion final.',
                ],
            ]);
        }

        $simulation = $service->simulate(
            $productType,
            $settings,
            $presentations,
            (float) $validated['target_output_kg'],
            $quantities
        );

        return $this->renderIndex(
            'simulator',
            $simulation,
            (int) $validated['cost_product_type_id'],
            [
                'cost_product_type_id' => (int) $validated['cost_product_type_id'],
                'target_output_kg' => (float) $validated['target_output_kg'],
                'quantities' => $validated['quantities'] ?? [],
            ]
        );
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'monthly_salary' => ['required', 'numeric', 'min:0'],
            'working_days_per_month' => ['required', 'integer', 'min:1'],
            'working_hours_per_day' => ['required', 'numeric', 'min:0.1'],
        ]);

        $settings = CostSetting::query()->first();

        if ($settings) {
            $settings->update($validated);
        } else {
            CostSetting::create($validated);
        }

        return redirect()
            ->route('costs.index', ['tab' => 'products'])
            ->with('status', 'Configuracion global actualizada con exito.');
    }

    private function renderIndex(
        string $activeTab = 'simulator',
        ?array $simulation = null,
        int $selectedProductTypeId = 0,
        array $simulationInput = []
    ) {
        $productTypes = CostProductType::with('formulaItems.ingredient')->orderBy('name')->get();
        $ingredients = CostIngredient::orderBy('name')->get();
        $presentations = CostPresentation::ordered()->get();
        $costSettings = $this->getCostSettings();
        $priceList = app(CostBudgetService::class)->buildPriceList(
            $productTypes->where('state', 1)->values(),
            $costSettings,
            $presentations->where('state', 1)->values()
        );

        if ($selectedProductTypeId === 0 && $productTypes->isNotEmpty()) {
            $selectedProductTypeId = (int) $productTypes->first()->id;
        }

        return view('admin.costs.index', [
            'activeTab' => $activeTab,
            'productTypes' => $productTypes,
            'ingredients' => $ingredients,
            'presentations' => $presentations,
            'costSettings' => $costSettings,
            'priceList' => $priceList,
            'selectedProductTypeId' => $selectedProductTypeId,
            'simulation' => $simulation,
            'simulationInput' => $simulationInput,
        ]);
    }

    private function validateProductType(Request $request, ?CostProductType $productType = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'base_output_grams' => ['required', 'numeric', 'min:0.01'],
            'base_production_hours' => ['required', 'numeric', 'min:0.01'],
            'wholesale_multiplier' => ['required', 'numeric', 'min:0.01'],
            'retail_multiplier' => ['required', 'numeric', 'min:0.01'],
            'discount_percentage' => ['required', 'numeric', 'min:0'],
            'state' => ['nullable', 'integer', 'in:0,1'],
        ]);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug !== '' ? $baseSlug : 'producto';
        $suffix = 2;

        while (
            CostProductType::where('slug', $slug)
                ->when($ignoreId, function ($query, $ignoreId) {
                    return $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }

    private function getCostSettings(): CostSetting
    {
        return CostSetting::query()->first() ?? new CostSetting([
            'monthly_salary' => 2200000,
            'working_days_per_month' => 30,
            'working_hours_per_day' => 8,
        ]);
    }
}
