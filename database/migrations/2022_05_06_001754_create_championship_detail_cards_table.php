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
        Schema::create('championship_detail_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championship_id')->nullable()->constrained('championships');
            $table->foreignId('player_id')->nullable()->constrained('players');
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
        Schema::dropIfExists('championship_detail_cards');
    }
}
