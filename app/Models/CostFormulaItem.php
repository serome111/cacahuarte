<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CostFormulaItem extends Model
{
    use HasFactory;

    protected $fillable = ['cost_product_type_id', 'cost_ingredient_id', 'grams', 'sort_order'];

    protected $casts = [
        'grams' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(CostIngredient::class, 'cost_ingredient_id');
    }

    public function productType(): BelongsTo
    {
        return $this->belongsTo(CostProductType::class, 'cost_product_type_id');
    }
}
