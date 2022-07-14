<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionshipsDetailsPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championships_details_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championships_detail_id')->nullable()->constrained('championships_details');
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
        Schema::dropIfExists('championships_details_players');
    }
}
