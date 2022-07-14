<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionshipsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championships_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championships_category_id')->nullable()->constrained('championships_categories');
            $table->foreignId('local_id')->nullable()->constrained('teams');
            $table->foreignId('visitor_id')->nullable()->constrained('teams');
            $table->string('title')->nullable();
            $table->datetime('datetime');
            $table->string('location')->nullable();
            $table->foreignId('winner_id')->nullable()->constrained('teams');
            $table->string('win_type')->nullable()->default('normal');
            $table->string('status')->nullable()->default('pendiente');
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
        Schema::dropIfExists('championships_details');
    }
}
