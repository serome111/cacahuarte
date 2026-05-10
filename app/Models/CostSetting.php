<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostSetting extends Model
{
    use HasFactory;

    protected $fillable = ['monthly_salary', 'working_days_per_month', 'working_hours_per_day'];

    protected $casts = [
        'monthly_salary' => 'decimal:2',
        'working_days_per_month' => 'integer',
        'working_hours_per_day' => 'decimal:2',
    ];
}
