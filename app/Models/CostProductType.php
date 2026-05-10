<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CostProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_output_grams',
        'base_production_hours',
        'monthly_salary',
        'working_days_per_month',
        'working_hours_per_day',
        'wholesale_multiplier',
        'retail_multiplier',
        'discount_percentage',
        'state',
    ];

    protected $casts = [
        'base_output_grams' => 'decimal:2',
        'base_production_hours' => 'decimal:2',
        'monthly_salary' => 'decimal:2',
        'working_days_per_month' => 'integer',
        'working_hours_per_day' => 'decimal:2',
        'wholesale_multiplier' => 'decimal:2',
        'retail_multiplier' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'state' => 'integer',
    ];

    public function formulaItems(): HasMany
    {
        return $this->hasMany(CostFormulaItem::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeActive($query)
    {
        return $query->where('state', 1);
    }
}
