<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateWhyAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('why_about_us', function(Blueprint $table){
        	$table->increments('id');
			$table->string('title');
			$table->text('description');
			$table->integer('icon_id')->index();
            $table->integer('state')->defaut(0);
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
        Schema::dropIfExists('why_about_us');
    }
}
