<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->nullable()->constrained('players');
            $table->string('type')->nullable();
            $table->string('full_name')->nullable();
            $table->string('ci')->nullable();
            $table->string('origin')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('player_documents');
    }
}
