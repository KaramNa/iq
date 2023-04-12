<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_takers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique()->index();
            $table->string('email')->unique()->index();
            $table->date('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('country')->nullable();
            $table->longText('bio')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('test_takers');
    }
};
