<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostPresentation extends Model
{
    use HasFactory;

    protected $fillable = ['reference', 'name', 'grams', 'package_cost', 'label_cost', 'sort_order', 'state'];

    protected $casts = [
        'grams' => 'decimal:2',
        'package_cost' => 'decimal:2',
        'label_cost' => 'decimal:2',
        'sort_order' => 'integer',
        'state' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('state', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('grams');
    }
}
