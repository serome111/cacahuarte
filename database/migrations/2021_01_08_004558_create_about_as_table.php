<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutAsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_as', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->default(0);
            $table->string('title');
            $table->text('description');
            $table->text('favicon1');
            $table->string('title1');
            $table->text('description1');
            $table->text('favicon2');
            $table->string('title2');
            $table->text('description2');
            $table->text('favicon3');
            $table->string('title3');
            $table->text('description3');
            $table->string('link', 255)->default('0');
            $table->integer('state')->default('0');
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
        Schema::dropIfExists('about_as');
    }
}
