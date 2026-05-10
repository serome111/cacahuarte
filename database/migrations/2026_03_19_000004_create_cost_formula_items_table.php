<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostFormulaItemsTable extends Migration
{
    public function up()
    {
        Schema::create('cost_formula_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_product_type_id')->constrained('cost_product_types')->cascadeOnDelete();
            $table->foreignId('cost_ingredient_id')->constrained('cost_ingredients')->restrictOnDelete();
            $table->decimal('grams', 12, 2);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['cost_product_type_id', 'cost_ingredient_id'], 'cost_formula_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cost_formula_items');
    }
}
