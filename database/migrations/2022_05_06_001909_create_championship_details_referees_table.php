<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionshipDetailRefereesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championship_details_referees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championship_detail_id')->nullable()->constrained('championship_details');
            $table->foreignId('referee_id')->nullable()->constrained('referees');
            $table->string('type')->nullable()->default('principal');
            $table->string('text')->nullable();
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
        Schema::dropIfExists('championship_detail_referees');
    }
}
