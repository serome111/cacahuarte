@extends('layout-dashboard')

@section('title','Cacahuarte | Costos y Presupuestos')

@php
    $tab = $activeTab ?? 'simulator';
    $money = fn ($value) => '$ ' . number_format((float) $value, 2, ',', '.');
    $number = fn ($value, $decimals = 2) => number_format((float) $value, $decimals, ',', '.');
@endphp

@section('content')
<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h2 mb-1">Costos y Presupuestos</h1>
            <p class="text-muted mb-0">Administra formulas, costos base y simulaciones de produccion usando la logica del archivo Excel.</p>
        </div>
    </div>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Revisa los datos ingresados.</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'simulator' ? 'active' : '' }}" href="{{ route('costs.index', ['tab' => 'simulator', 'product_type' => $selectedProductTypeId]) }}">Simulador</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'products' ? 'active' : '' }}" href="{{ route('costs.index', ['tab' => 'products']) }}">Tipos de producto</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'ingredients' ? 'active' : '' }}" href="{{ route('costs.index', ['tab' => 'ingredients']) }}">Insumos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'presentations' ? 'active' : '' }}" href="{{ route('costs.index', ['tab' => 'presentations']) }}">Presentaciones</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'formulas' ? 'active' : '' }}" href="{{ route('costs.index', ['tab' => 'formulas']) }}">Formulaciones</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'price-list' ? 'active' : '' }}" href="{{ route('costs.index', ['tab' => 'price-list']) }}">Listado de precios</a>
        </li>
    </ul>

    @if($tab === 'simulator')
        @php
            $simulatorTargetOutputKg = (float) old('target_output_kg', $simulationInput['target_output_kg'] ?? 100);
            $simulatorTargetOutputGrams = $simulatorTargetOutputKg * 1000;
        @endphp
        <div class="row g-4">
            <div class="col-xl-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Simular presupuesto</h2>
                        @if($productTypes->isEmpty())
                            <p class="text-muted mb-0">Primero crea tipos de producto e insumos para empezar a simular.</p>
                        @else
                            <form action="{{ route('costs.simulate') }}" method="POST" class="row g-3">
                                @csrf
                                <div class="col-12">
                                    <label class="form-label">Tipo de producto</label>
                                    <select name="cost_product_type_id" class="form-select" required>
                                        @foreach($productTypes as $productType)
                                            <option value="{{ $productType->id }}" {{ (int) old('cost_product_type_id', $simulationInput['cost_product_type_id'] ?? $selectedProductTypeId) === $productType->id ? 'selected' : '' }}>
                                                {{ $productType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Produccion objetivo (kg finales)</label>
                                    <input type="number" id="targetOutputKg" name="target_output_kg" class="form-control" min="0.01" step="0.01" value="{{ old('target_output_kg', $simulationInput['target_output_kg'] ?? 100) }}" required>
                                </div>
                                <div class="col-12">
                                    <h3 class="h6 mt-2">Cantidades por referencia</h3>
                                    <p class="text-muted small mb-2">Estas cantidades son opcionales y sirven para repartir la produccion final entre bolsas. La suma en gramos de todas las bolsas no deberia superar la produccion objetivo.</p>
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-light border small mb-0" id="packagingReferenceSummary">
                                        Para {{ $number($simulatorTargetOutputKg, 2) }} kg finales, aun no has repartido bolsas. Si todo lo restante fuera en una sola referencia, podrias agregar como maximo:
                                        @foreach($presentations as $presentation)
                                            @php
                                                $maxUnitsForPresentation = $presentation->grams > 0 ? floor($simulatorTargetOutputGrams / $presentation->grams) : 0;
                                            @endphp
                                            <span class="d-block" data-summary-entry data-grams="{{ $presentation->grams }}" data-name="{{ $presentation->name }}">
                                                {{ $presentation->name }}: {{ $number($maxUnitsForPresentation, 0) }} unidades adicionales
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                @foreach($presentations as $presentation)
                                    @php
                                        $maxUnitsForPresentation = $presentation->grams > 0 ? floor($simulatorTargetOutputGrams / $presentation->grams) : 0;
                                        $quantityInputValue = old('quantities.' . $presentation->id, $simulationInput['quantities'][$presentation->id] ?? null);
                                        $displayQuantityInputValue = (int) $quantityInputValue > 0 ? (int) $quantityInputValue : '';
                                    @endphp
                                    <div class="col-6">
                                        <label class="form-label">{{ $presentation->name }}</label>
                                        <input
                                            type="number"
                                            min="0"
                                            step="1"
                                            max="{{ $maxUnitsForPresentation }}"
                                            class="form-control"
                                            data-presentation-grams="{{ $presentation->grams }}"
                                            data-presentation-name="{{ $presentation->name }}"
                                            name="quantities[{{ $presentation->id }}]"
                                            value="{{ $displayQuantityInputValue }}"
                                            placeholder="{{ $maxUnitsForPresentation }}"
                                        >
                                        <div class="form-text">
                                            Maximo total con el reparto actual:
                                            <span data-presentation-limit data-grams="{{ $presentation->grams }}">{{ $number($maxUnitsForPresentation, 0) }}</span>
                                            unidades.
                                            Aun puedes agregar
                                            <span data-presentation-extra-limit data-grams="{{ $presentation->grams }}">{{ $number($maxUnitsForPresentation, 0) }}</span>
                                            mas.
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-12 d-grid">
                                    <button type="submit" class="btn btn-dark">Calcular presupuesto</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="row g-3">
                    <div class="col-md-6 col-xl-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <p class="text-muted mb-1">Tipos activos</p>
                                <h2 class="h4 mb-0">{{ $productTypes->where('state', 1)->count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <p class="text-muted mb-1">Insumos activos</p>
                                <h2 class="h4 mb-0">{{ $ingredients->where('state', 1)->count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <p class="text-muted mb-1">Presentaciones</p>
                                <h2 class="h4 mb-0">{{ $presentations->where('state', 1)->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                @if($simulation)
                    <div class="card shadow-sm mt-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
                                <div>
                                    <h2 class="h5 mb-1">{{ $simulation['summary']['product_type'] }}</h2>
                                    <p class="text-muted mb-0">Produccion objetivo: {{ $number($simulation['summary']['target_output_kg']) }} kg finales</p>
                                </div>
                                <div class="text-end">
                                    <p class="mb-1"><strong>Escala:</strong> {{ $number($simulation['summary']['scale_factor'], 3) }}x</p>
                                    <p class="mb-0"><strong>Merma estimada:</strong> {{ $number($simulation['summary']['yield_loss_percent']) }}%</p>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6 col-xl-3">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">Costo de insumos</p>
                                        <h3 class="h5 mb-0">{{ $money($simulation['summary']['total_ingredient_cost']) }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">Costo mano de obra</p>
                                        <h3 class="h5 mb-0">{{ $money($simulation['summary']['total_labor_cost']) }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">Costo insumo / gr final</p>
                                        <h3 class="h5 mb-0">{{ $money($simulation['summary']['ingredient_cost_per_finished_gram']) }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">Costo mano obra / gr</p>
                                        <h3 class="h5 mb-0">{{ $money($simulation['summary']['labor_cost_per_finished_gram']) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-4">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Requerimiento de insumos</h2>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Insumo</th>
                                            <th>Base (g)</th>
                                            <th>Requerido (g)</th>
                                            <th>Requerido (kg)</th>
                                            <th>Costo x kg</th>
                                            <th>Costo total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($simulation['ingredients'] as $ingredient)
                                            <tr>
                                                <td>{{ $ingredient['ingredient'] }}</td>
                                                <td>{{ $number($ingredient['base_grams']) }}</td>
                                                <td>{{ $number($ingredient['required_grams']) }}</td>
                                                <td>{{ $number($ingredient['required_kg'], 3) }}</td>
                                                <td>{{ $money($ingredient['cost_per_kg']) }}</td>
                                                <td>{{ $money($ingredient['total_cost']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Totales</th>
                                            <th>{{ $number($simulation['summary']['total_input_grams']) }}</th>
                                            <th>{{ $number($simulation['summary']['total_input_grams'] / 1000, 3) }}</th>
                                            <th></th>
                                            <th>{{ $money($simulation['summary']['total_ingredient_cost']) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-4">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Tabla de costos y precios</h2>
                            <p class="text-muted small mb-3">
                                Todos los valores de esta tabla son unitarios y corresponden a 1 bolsa de cada referencia.
                                Las cantidades ingresadas solo se usan para la cotizacion total.
                            </p>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Ref</th>
                                            <th>Presentacion</th>
                                            <th>Costo producto</th>
                                            <th>Mano obra</th>
                                            <th>Empaque</th>
                                            <th>Etiqueta</th>
                                            <th>Costo neto</th>
                                            <th>Mayorista</th>
                                            <th>Minorista</th>
                                            <th>Desc.</th>
                                            <th>Unidad base</th>
                                            <th>Unidades cotizadas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($simulation['presentations'] as $presentation)
                                            <tr>
                                                <td>{{ $presentation['reference'] }}</td>
                                                <td>{{ $presentation['name'] }}</td>
                                                <td>{{ $money($presentation['ingredient_cost']) }}</td>
                                                <td>{{ $money($presentation['labor_cost']) }}</td>
                                                <td>{{ $money($presentation['package_cost']) }}</td>
                                                <td>{{ $money($presentation['label_cost']) }}</td>
                                                <td><strong>{{ $money($presentation['net_cost']) }}</strong></td>
                                                <td>{{ $money($presentation['wholesale_price']) }}</td>
                                                <td>{{ $money($presentation['retail_price']) }}</td>
                                                <td>{{ $money($presentation['discount_amount']) }}</td>
                                                <td>1</td>
                                                <td>{{ $presentation['quantity'] > 0 ? $number($presentation['quantity'], 0) : 'Sin definir' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-4">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Totales de cotizacion por cantidades ingresadas</h2>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="border rounded p-3">
                                        <p class="text-muted mb-1">Unidades presupuestadas</p>
                                        <h3 class="h5 mb-0">{{ $number($simulation['quote_totals']['units'], 0) }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3">
                                        <p class="text-muted mb-1">Costo total</p>
                                        <h3 class="h5 mb-0">{{ $money($simulation['quote_totals']['cost']) }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3">
                                        <p class="text-muted mb-1">Venta minorista total</p>
                                        <h3 class="h5 mb-0">{{ $money($simulation['quote_totals']['retail']) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-4">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Control de empaque</h2>

                            @if($simulation['summary']['is_packaging_valid'])
                                <div class="alert alert-success">
                                    El reparto de bolsas es valido para la produccion objetivo.
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    El reparto de bolsas no es posible: estas intentando empacar
                                    {{ $number($simulation['summary']['packaged_grams'] / 1000, 2) }} kg
                                    con una produccion de
                                    {{ $number($simulation['summary']['target_output_kg'], 2) }} kg.
                                    Debes reducir
                                    {{ $number($simulation['summary']['over_allocated_grams'] / 1000, 2) }} kg
                                    en bolsas.
                                </div>
                            @endif

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">Produccion final disponible</p>
                                        <h3 class="h5 mb-0">{{ $number($simulation['summary']['target_output_kg'], 2) }} kg</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">Empaque solicitado</p>
                                        <h3 class="h5 mb-0">{{ $number($simulation['summary']['packaged_grams'] / 1000, 2) }} kg</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">{{ $simulation['summary']['is_packaging_valid'] ? 'Saldo sin empacar' : 'Exceso empacado' }}</p>
                                        <h3 class="h5 mb-0">
                                            {{ $number(($simulation['summary']['is_packaging_valid'] ? $simulation['summary']['remaining_packable_grams'] : $simulation['summary']['over_allocated_grams']) / 1000, 2) }} kg
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Presentacion</th>
                                            <th>Unidades solicitadas</th>
                                            <th>Gramos empacados</th>
                                            <th>Maximo si todo fuera en esta ref.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($simulation['presentations'] as $presentation)
                                            <tr>
                                                <td>{{ $presentation['name'] }}</td>
                                                <td>{{ $number($presentation['quantity'], 0) }}</td>
                                                <td>{{ $number($presentation['allocated_grams'], 0) }} g</td>
                                                <td>{{ $number($presentation['max_units_if_only_this_presentation'], 0) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if($tab === 'simulator')
        <script>
            (() => {
                const targetInput = document.getElementById('targetOutputKg');
                if (!targetInput) {
                    return;
                }

                const quantityInputs = Array.from(document.querySelectorAll('input[data-presentation-grams]'));
                const limitLabels = Array.from(document.querySelectorAll('[data-presentation-limit]'));
                const extraLimitLabels = Array.from(document.querySelectorAll('[data-presentation-extra-limit]'));
                const summaryEntries = Array.from(document.querySelectorAll('[data-summary-entry]'));
                const summaryBox = document.getElementById('packagingReferenceSummary');
                const formatNumber = (value) => new Intl.NumberFormat('es-CO', {
                    maximumFractionDigits: 0,
                }).format(value);
                const formatKg = (value) => new Intl.NumberFormat('es-CO', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }).format(value);
                const parseQuantity = (input) => {
                    const value = parseInt(input.value, 10);
                    return Number.isFinite(value) && value > 0 ? value : 0;
                };
                const updatePackagingLimits = () => {
                    const targetKg = parseFloat(targetInput.value) || 0;
                    const targetGrams = targetKg * 1000;
                    const allocatedGrams = quantityInputs.reduce((sum, input) => {
                        const grams = parseFloat(input.dataset.presentationGrams || '0');
                        return sum + (parseQuantity(input) * grams);
                    }, 0);
                    const remainingGrams = targetGrams - allocatedGrams;

                    quantityInputs.forEach((input) => {
                        const grams = parseFloat(input.dataset.presentationGrams || '0');
                        const currentUnits = parseQuantity(input);
                        const currentAllocatedGrams = currentUnits * grams;
                        const allocatedByOthers = allocatedGrams - currentAllocatedGrams;
                        const availableGramsForThis = Math.max(targetGrams - allocatedByOthers, 0);
                        const totalUnitsAllowed = grams > 0 ? Math.floor(availableGramsForThis / grams) : 0;
                        const additionalUnitsAllowed = Math.max(totalUnitsAllowed - currentUnits, 0);

                        input.max = String(totalUnitsAllowed);
                        input.placeholder = additionalUnitsAllowed > 0 ? String(additionalUnitsAllowed) : '0';
                        input.classList.toggle('is-invalid', currentUnits > totalUnitsAllowed);
                    });

                    limitLabels.forEach((label) => {
                        const grams = parseFloat(label.dataset.grams || '0');
                        const input = quantityInputs.find((item) => parseFloat(item.dataset.presentationGrams || '0') === grams);
                        const totalUnitsAllowed = input ? parseInt(input.max || '0', 10) || 0 : 0;
                        label.textContent = formatNumber(totalUnitsAllowed);
                    });

                    extraLimitLabels.forEach((label) => {
                        const grams = parseFloat(label.dataset.grams || '0');
                        const input = quantityInputs.find((item) => parseFloat(item.dataset.presentationGrams || '0') === grams);
                        const currentUnits = input ? parseQuantity(input) : 0;
                        const totalUnitsAllowed = input ? parseInt(input.max || '0', 10) || 0 : 0;
                        label.textContent = formatNumber(Math.max(totalUnitsAllowed - currentUnits, 0));
                    });

                    summaryEntries.forEach((entry) => {
                        const grams = parseFloat(entry.dataset.grams || '0');
                        const name = entry.dataset.name || '';
                        const maxUnits = grams > 0 ? Math.floor(Math.max(remainingGrams, 0) / grams) : 0;
                        entry.textContent = `${name}: ${formatNumber(maxUnits)} unidades adicionales`;
                    });

                    if (summaryBox) {
                        summaryBox.classList.remove('alert-light', 'alert-success', 'alert-danger');

                        if (allocatedGrams > targetGrams) {
                            summaryBox.classList.add('alert-danger');
                        } else {
                            summaryBox.classList.add('alert-success');
                        }

                        const prefix = summaryBox.firstChild;
                        if (prefix && prefix.nodeType === Node.TEXT_NODE) {
                            if (allocatedGrams > targetGrams) {
                                prefix.textContent = `Para ${formatKg(targetKg)} kg finales, ya asignaste ${formatKg(allocatedGrams / 1000)} kg en bolsas. Te pasaste por ${formatKg((allocatedGrams - targetGrams) / 1000)} kg. `;
                            } else {
                                prefix.textContent = `Para ${formatKg(targetKg)} kg finales, ya asignaste ${formatKg(allocatedGrams / 1000)} kg y te quedan ${formatKg(Math.max(remainingGrams, 0) / 1000)} kg por repartir. Si todo lo restante fuera en una sola referencia, aun podrias agregar como maximo: `;
                            }
                        }
                    }
                };

                quantityInputs.forEach((input) => {
                    input.addEventListener('input', updatePackagingLimits);
                    input.addEventListener('blur', () => {
                        if (parseQuantity(input) === 0) {
                            input.value = '';
                        }
                    });
                });
                targetInput.addEventListener('input', updatePackagingLimits);
                updatePackagingLimits();
            })();
        </script>
    @endif

    @if($tab === 'price-list')
        @php
            $priceListColors = ['#bcd99b', '#f7df92', '#b8caea', '#f3c0c0', '#c8d6a3', '#d9c7f0'];
        @endphp

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="h5 mb-2">Listado de precios automatico</h2>
                <p class="text-muted mb-0">Esta vista se recalcula con los valores guardados en insumos, presentaciones, formulaciones y configuracion global de mano de obra. Cada bloque usa la produccion base definida para ese producto.</p>
            </div>
        </div>

        @forelse($priceList as $group)
            <div class="card shadow-sm mb-4 border-0">
                <div
                    class="card-header border-0 text-center fw-bold"
                    style="background-color: {{ $priceListColors[($loop->index) % count($priceListColors)] }};"
                >
                    {{ $loop->iteration }}, {{ $group['product_type_name'] }}
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0 align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>REF</th>
                                    <th>PESO (gr)</th>
                                    <th>COSTO</th>
                                    <th>PRECIO MAYORISTA</th>
                                    <th>PRECIO MINORISTA</th>
                                    <th>DESC.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group['rows'] as $row)
                                    <tr>
                                        <td>{{ $row['reference'] }}</td>
                                        <td>{{ $number($row['grams'], 0) }}</td>
                                        <td>{{ $money($row['net_cost']) }}</td>
                                        <td>{{ $money($row['wholesale_price']) }}</td>
                                        <td>{{ $money($row['retail_price']) }}</td>
                                        <td>{{ $money($row['discount_amount']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-muted small">
                    Produccion base: {{ $number($group['base_output_grams'] / 1000, 2) }} kg |
                    Horas base: {{ $number($group['base_production_hours'], 2) }}
                </div>
            </div>
        @empty
            <div class="alert alert-secondary mb-0">
                No hay tipos de producto activos con presentaciones para generar el listado de precios.
            </div>
        @endforelse
    @endif

    @if($tab === 'products')
        <div class="row g-4">
            <div class="col-xl-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Configuracion global de mano de obra</h2>
                        <p class="text-muted small">Estos valores aplican a todos los tipos de producto. Ya no es necesario repetirlos en cada producto nuevo.</p>
                        <form action="{{ route('costs.settings.update') }}" method="POST" class="row g-3">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label class="form-label">Salario mensual</label>
                                <input type="number" name="monthly_salary" class="form-control" min="0" step="0.01" value="{{ $costSettings->monthly_salary }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Dias / mes</label>
                                <input type="number" name="working_days_per_month" class="form-control" min="1" step="1" value="{{ $costSettings->working_days_per_month }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Horas / dia</label>
                                <input type="number" name="working_hours_per_day" class="form-control" min="0.1" step="0.1" value="{{ $costSettings->working_hours_per_day }}" required>
                            </div>
                            <div class="col-12 d-grid">
                                <button type="submit" class="btn btn-outline-dark">Guardar configuracion</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Nuevo tipo de producto</h2>
                        <form action="{{ route('costs.product-types.store') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descripcion</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Salida base (g)</label>
                                <input type="number" name="base_output_grams" class="form-control" min="0.01" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Horas base</label>
                                <input type="number" name="base_production_hours" class="form-control" min="0.01" step="0.01" value="7" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Multiplicador mayorista</label>
                                <input type="number" name="wholesale_multiplier" class="form-control" min="0.01" step="0.01" value="2.15" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Multiplicador minorista</label>
                                <input type="number" name="retail_multiplier" class="form-control" min="0.01" step="0.01" value="3" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">% descuento</label>
                                <input type="number" name="discount_percentage" class="form-control" min="0" step="0.01" value="10" required>
                            </div>
                            <div class="col-12 d-grid">
                                <button type="submit" class="btn btn-dark">Guardar producto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                @foreach($productTypes as $productType)
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <form action="{{ route('costs.product-types.update', $productType) }}" method="POST" class="row g-3">
                                @csrf
                                @method('PUT')
                                <div class="col-md-6">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="name" class="form-control" value="{{ $productType->name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Estado</label>
                                    <select name="state" class="form-select">
                                        <option value="1" {{ $productType->state === 1 ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ $productType->state === 0 ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Descripcion</label>
                                    <textarea name="description" class="form-control" rows="2">{{ $productType->description }}</textarea>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Salida base (g)</label>
                                    <input type="number" name="base_output_grams" class="form-control" step="0.01" min="0.01" value="{{ $productType->base_output_grams }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Horas base</label>
                                    <input type="number" name="base_production_hours" class="form-control" step="0.01" min="0.01" value="{{ $productType->base_production_hours }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Mayorista</label>
                                    <input type="number" name="wholesale_multiplier" class="form-control" step="0.01" min="0.01" value="{{ $productType->wholesale_multiplier }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Minorista</label>
                                    <input type="number" name="retail_multiplier" class="form-control" step="0.01" min="0.01" value="{{ $productType->retail_multiplier }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">% descuento</label>
                                    <input type="number" name="discount_percentage" class="form-control" step="0.01" min="0" value="{{ $productType->discount_percentage }}" required>
                                </div>
                                <div class="col-12 d-grid d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-outline-dark">Guardar cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($tab === 'ingredients')
        <div class="row g-4">
            <div class="col-xl-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Nuevo insumo</h2>
                        <form action="{{ route('costs.ingredients.store') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Costo por kg</label>
                                <input type="number" name="cost_per_kg" class="form-control" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Unidad</label>
                                <input type="text" name="unit" class="form-control" value="kg">
                            </div>
                            <div class="col-12 d-grid">
                                <button type="submit" class="btn btn-dark">Guardar insumo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Catalogo de insumos</h2>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Costo x kg</th>
                                        <th>Unidad</th>
                                        <th>Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ingredients as $ingredient)
                                        <tr>
                                            <td colspan="5">
                                                <form action="{{ route('costs.ingredients.update', $ingredient) }}" method="POST" class="row g-2 align-items-end">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="col-md-3">
                                                        <input type="text" name="name" class="form-control" value="{{ $ingredient->name }}" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="number" name="cost_per_kg" class="form-control" min="0" step="0.01" value="{{ $ingredient->cost_per_kg }}" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="unit" class="form-control" value="{{ $ingredient->unit }}" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="state" class="form-select">
                                                            <option value="1" {{ $ingredient->state === 1 ? 'selected' : '' }}>Activo</option>
                                                            <option value="0" {{ $ingredient->state === 0 ? 'selected' : '' }}>Inactivo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 d-grid">
                                                        <button type="submit" class="btn btn-outline-dark">Guardar</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($tab === 'presentations')
        <div class="row g-4">
            <div class="col-xl-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Nueva presentacion</h2>
                        <form action="{{ route('costs.presentations.store') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-md-4">
                                <label class="form-label">Ref</label>
                                <input type="text" name="reference" class="form-control" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Gramos</label>
                                <input type="number" name="grams" class="form-control" min="0.01" step="0.01" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Empaque</label>
                                <input type="number" name="package_cost" class="form-control" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Etiqueta</label>
                                <input type="number" name="label_cost" class="form-control" min="0" step="0.01" required>
                            </div>
                            <div class="col-12 d-grid">
                                <button type="submit" class="btn btn-dark">Guardar presentacion</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Presentaciones activas</h2>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Ref</th>
                                        <th>Nombre</th>
                                        <th>Gramos</th>
                                        <th>Empaque</th>
                                        <th>Etiqueta</th>
                                        <th>Orden</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presentations as $presentation)
                                        <tr>
                                            <td colspan="7">
                                                <form action="{{ route('costs.presentations.update', $presentation) }}" method="POST" class="row g-2 align-items-end">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="col-md-1">
                                                        <input type="text" name="reference" class="form-control" value="{{ $presentation->reference }}" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" name="name" class="form-control" value="{{ $presentation->name }}" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <input type="number" name="grams" class="form-control" min="0.01" step="0.01" value="{{ $presentation->grams }}" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" name="package_cost" class="form-control" min="0" step="0.01" value="{{ $presentation->package_cost }}" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" name="label_cost" class="form-control" min="0" step="0.01" value="{{ $presentation->label_cost }}" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <input type="number" name="sort_order" class="form-control" min="0" step="1" value="{{ $presentation->sort_order }}" required>
                                                    </div>
                                                    <div class="col-md-2 d-grid">
                                                        <button type="submit" class="btn btn-outline-dark">Guardar</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($tab === 'formulas')
        <div class="row g-4">
            @foreach($productTypes as $productType)
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                <div>
                                    <h2 class="h5 mb-1">{{ $productType->name }}</h2>
                                    <p class="text-muted mb-0">Salida base: {{ $number($productType->base_output_grams) }} g | Horas base: {{ $number($productType->base_production_hours) }}</p>
                                </div>
                            </div>

                            <div class="table-responsive mb-3">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Ingrediente</th>
                                            <th>Gramos base</th>
                                            <th>Orden</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($productType->formulaItems as $formulaItem)
                                            <tr>
                                                <td>{{ $formulaItem->ingredient->name }}</td>
                                                <td colspan="3">
                                                    <form action="{{ route('costs.formulas.update', $formulaItem) }}" method="POST" class="row g-2 align-items-end">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="col-md-4">
                                                            <input type="number" name="grams" class="form-control" min="0.01" step="0.01" value="{{ $formulaItem->grams }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="number" name="sort_order" class="form-control" min="0" step="1" value="{{ $formulaItem->sort_order }}" required>
                                                        </div>
                                                        <div class="col-md-4 d-grid">
                                                            <button type="submit" class="btn btn-outline-dark">Actualizar</button>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td class="text-end">
                                                    <form action="{{ route('costs.formulas.destroy', $formulaItem) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger">Quitar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <form action="{{ route('costs.formulas.store') }}" method="POST" class="row g-3">
                                @csrf
                                <input type="hidden" name="cost_product_type_id" value="{{ $productType->id }}">
                                <div class="col-md-5">
                                    <label class="form-label">Agregar ingrediente</label>
                                    <select name="cost_ingredient_id" class="form-select" required>
                                        <option value="">Selecciona un insumo</option>
                                        @foreach($ingredients as $ingredient)
                                            <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Gramos base</label>
                                    <input type="number" name="grams" class="form-control" min="0.01" step="0.01" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Orden</label>
                                    <input type="number" name="sort_order" class="form-control" min="0" step="1" value="{{ $productType->formulaItems->count() + 1 }}" required>
                                </div>
                                <div class="col-md-2 d-grid">
                                    <button type="submit" class="btn btn-dark">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>
@endsection()
