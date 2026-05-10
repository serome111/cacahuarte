<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCostSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('cost_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('monthly_salary', 12, 2)->default(2200000);
            $table->unsignedInteger('working_days_per_month')->default(30);
            $table->decimal('working_hours_per_day', 5, 2)->default(8);
            $table->timestamps();
        });

        $defaults = [
            'monthly_salary' => 2200000,
            'working_days_per_month' => 30,
            'working_hours_per_day' => 8,
        ];

        if (Schema::hasTable('cost_product_types')) {
            $current = DB::table('cost_product_types')
                ->select('monthly_salary', 'working_days_per_month', 'working_hours_per_day')
                ->orderBy('id')
                ->first();

            if ($current) {
                $defaults = [
                    'monthly_salary' => $current->monthly_salary,
                    'working_days_per_month' => $current->working_days_per_month,
                    'working_hours_per_day' => $current->working_hours_per_day,
                ];
            }
        }

        DB::table('cost_settings')->insert([
            'id' => 1,
            'monthly_salary' => $defaults['monthly_salary'],
            'working_days_per_month' => $defaults['working_days_per_month'],
            'working_hours_per_day' => $defaults['working_hours_per_day'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('cost_settings');
    }
}
