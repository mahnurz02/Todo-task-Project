<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Taskcategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_category', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
                $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');;
            $table->unsignedInteger('task_id');
                $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');;
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_category');
    }
}
