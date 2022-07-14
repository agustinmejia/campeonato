<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionshipsDetailsCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championships_details_players_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championships_details_player_id')->nullable()->constrained('championships_details_players')->index('championship_detail_player_card_championship_detail_player');
            $table->string('type')->nullable();
            $table->string('time')->nullable();
            $table->smallInteger('accumulated')->nullable()->default(1);
            $table->smallInteger('paid')->nullable()->default(0);
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
        Schema::dropIfExists('championships_details_players_cards');
    }
}
