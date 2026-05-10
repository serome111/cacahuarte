<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostPresentationsTable extends Migration
{
    public function up()
    {
        Schema::create('cost_presentations', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 50);
            $table->string('name');
            $table->decimal('grams', 12, 2);
            $table->decimal('package_cost', 12, 2)->default(0);
            $table->decimal('label_cost', 12, 2)->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->integer('state')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cost_presentations');
    }
}
