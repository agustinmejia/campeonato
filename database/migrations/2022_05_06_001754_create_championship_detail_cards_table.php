<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionshipDetailCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championship_details_players_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championship_details_player_id')->nullable()->constrained('championship_details_players')->index('championship_details_players_cards_championship_details_player');
            $table->string('type')->nullable();
            $table->string('time')->nullable();
            $table->smallInteger('accumulated')->nullable()->default(1);
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
        Schema::dropIfExists('championship_details_players_cards');
    }
}
