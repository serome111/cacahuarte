<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CostIngredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cost_per_kg', 'unit', 'state'];

    protected $casts = [
        'cost_per_kg' => 'decimal:2',
        'state' => 'integer',
    ];

    public function formulaItems(): HasMany
    {
        return $this->hasMany(CostFormulaItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('state', 1);
    }
}
