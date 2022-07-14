<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionshipsDetailsRefereesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championships_details_referees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championships_detail_id')->nullable()->constrained('championships_details');
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
        Schema::dropIfExists('championships_details_referees');
    }
}
