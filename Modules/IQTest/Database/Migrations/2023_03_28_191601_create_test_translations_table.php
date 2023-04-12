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
        Schema::create('test_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id');
            $table->string('locale')->index();

            $table->text('title')->nullable();
            $table->string('slug')->nullable()->unique()->index();
            $table->longText('description')->nullable();
            $table->text('meta_description')->nullable();

            $table->unique(['test_id', 'locale']);
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_translations');
    }
};
