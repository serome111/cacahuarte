<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhyUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('why-uses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->default(0);
            $table->string('title');
            $table->text('description');
            $table->string('button');
            $table->string('titlec1');
            $table->text('descriptionc1');
            $table->string('titlec2');
            $table->text('descriptionc2');
            $table->string('titlec3');
            $table->text('descriptionc3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('why-uses');
    }
}
