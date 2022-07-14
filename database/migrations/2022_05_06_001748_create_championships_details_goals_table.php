<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionshipsDetailsGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championships_details_players_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championships_details_player_id')->nullable()->constrained('championships_details_players')->index('championship_detail_player_goal_championship_detail_player');
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
        Schema::dropIfExists('championships_details_players_goals');
    }
}
