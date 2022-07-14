<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionshipsTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championships_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championships_category_id')->nullable()->constrained('championships_categories');
            $table->foreignId('team_id')->nullable()->constrained('teams');
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
        Schema::dropIfExists('championships_teams');
    }
}
