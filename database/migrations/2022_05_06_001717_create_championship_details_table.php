<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionshipDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championship_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championship_id')->nullable()->constrained('championships');
            $table->foreignId('local_id')->nullable()->constrained('teams');
            $table->foreignId('visitor_id')->nullable()->constrained('teams');
            $table->string('title')->nullable();
            $table->datetime('datetime');
            $table->string('location')->nullable();
            $table->foreignId('winner_id')->nullable()->constrained('teams');
            $table->string('win_type')->nullable()->default('normal');
            $table->string('status')->nullable()->default('pendiente');
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
        Schema::dropIfExists('championship_details');
    }
}
