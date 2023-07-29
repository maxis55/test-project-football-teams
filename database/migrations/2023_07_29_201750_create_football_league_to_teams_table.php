<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('football_league_to_teams', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('team_id');

            $table->tinyInteger('points');
            $table->tinyInteger('matches_played');
            $table->tinyInteger('wins');
            $table->tinyInteger('loses');
            $table->tinyInteger('draws');
            $table->tinyInteger('goal_difference');

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onUpdate('NO ACTION')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('football_league_to_teams');
    }
};
