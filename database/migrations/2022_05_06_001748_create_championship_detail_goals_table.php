<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionshipDetailGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championship_details_players_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championship_details_player_id')->nullable()->constrained('championship_details_players')->index('championship_details_players_goals_championship_details_player');
            $table->foreignId('assistant_id')->nullable()->constrained('players');
            $table->string('type')->nullable()->default('normal');
            $table->string('time')->nullable();
            $table->string('observations')->nullable();
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
        Schema::dropIfExists('championship_details_players_goals');
    }
}
