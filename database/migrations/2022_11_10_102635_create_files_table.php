<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            //$table->bigInteger('owner_id')->default(0);
            $table->bigInteger('owner_id')->unsigned()->nullable();
            $table->foreign('owner_id')->references('id')->on('users');//->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');//->onDelete('cascade');
            $table->string('file_name')->nullable();
            $table->string('path')->nullable();
            $table->dateTime('datetime')->nullable();
           // $table->timestamps();
//
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
