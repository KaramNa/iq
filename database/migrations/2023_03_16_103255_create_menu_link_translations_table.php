<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_link_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('menu_link_id')->unsigned();
            $table->string('locale')->index();

            $table->text('title')->nullable();

            $table->unique(['menu_link_id','locale']);
            $table->foreign('menu_link_id')->references('id')->on('menu_links')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_link_translations');
    }
};
