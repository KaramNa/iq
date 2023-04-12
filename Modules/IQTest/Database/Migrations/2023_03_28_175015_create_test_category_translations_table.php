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
        Schema::create('test_category_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('test_category_id')->unsigned();
            $table->string('locale')->index();

            $table->string('name')->nullable();
            $table->string('slug')->unique()->index();
            $table->longText('description')->nullable();
            $table->text('meta_description')->nullable();

            $table->unique(['test_category_id','locale']);
            $table->foreign('test_category_id')->references('id')->on('test_categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_category_translations');
    }
};
