<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionshipsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championships_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championship_id')->nullable()->constrained('championships');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('status')->nullable()->default('activo');
            $table->timestamps();
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
        Schema::dropIfExists('championships_categories');
    }
}
