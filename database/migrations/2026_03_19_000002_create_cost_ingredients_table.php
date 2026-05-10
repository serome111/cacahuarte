<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostIngredientsTable extends Migration
{
    public function up()
    {
        Schema::create('cost_ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('cost_per_kg', 12, 2)->default(0);
            $table->string('unit')->default('kg');
            $table->integer('state')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cost_ingredients');
    }
}
