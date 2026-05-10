<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostProductTypesTable extends Migration
{
    public function up()
    {
        Schema::create('cost_product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('base_output_grams', 12, 2);
            $table->decimal('base_production_hours', 8, 2)->default(7);
            $table->decimal('monthly_salary', 12, 2)->default(2200000);
            $table->unsignedInteger('working_days_per_month')->default(30);
            $table->decimal('working_hours_per_day', 5, 2)->default(8);
            $table->decimal('wholesale_multiplier', 8, 2)->default(2.15);
            $table->decimal('retail_multiplier', 8, 2)->default(3);
            $table->decimal('discount_percentage', 5, 2)->default(10);
            $table->integer('state')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cost_product_types');
    }
}
