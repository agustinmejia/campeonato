<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionshipDetailsPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championship_details_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championship_detail_id')->nullable()->constrained('championship_details');
            $table->foreignId('player_id')->nullable()->constrained('players');
            $table->smallInteger('number')->nullable();
            $table->string('type')->nullable();
            $table->smallInteger('playing')->nullable();
            $table->string('status')->nullable()->default('activo');
            $table->text('observations')->nullable();
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
        Schema::dropIfExists('championship_details_players');
    }
}
