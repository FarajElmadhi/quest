<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// Auto Schema  By Baboon Script
// Baboon Maker has been Created And Developed By [it v 1.6.32]
// Copyright Reserved  [it v 1.6.32]
class CreatePlaiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plaies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id')->default(0);
            $table->string('token')->default('');
            $table->string('played')->default(0);
            $table->string('level')->default(1);
            $table->string('coins')->default(100);
            $table->string('time')->default(0);
            $table->string('is_now')->default(0);
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
        Schema::dropIfExists('plaies');
    }
}