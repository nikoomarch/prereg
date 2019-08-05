<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('field_id')->nullable();
            $table->integer('entranceTerm')->nullable();
            $table->string('name');
            $table->string('family');
            $table->string('gender')->nullable();
            $table->string('role');
            $table->string('username')->unique();
            $table->string('nationalCode')->nullable();
            $table->boolean('isAllowed')->default(false);
            $table->string('password');
            $table->foreign('field_id')
                ->references('id')
                ->on('fields')
                ->onDelete('cascade');
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
        Schema::dropIfExists('users');
    }
}
