<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('football_league_to_teams', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('league_id');

            $table->tinyInteger('points')->default(0);
            $table->tinyInteger('matches_played')->default(0);
            $table->tinyInteger('wins')->default(0);
            $table->tinyInteger('loses')->default(0);
            $table->tinyInteger('draws')->default(0);
            $table->tinyInteger('goal_difference')->default(0);

            $table->unique(['team_id', 'league_id']);

            $table->foreign('team_id')
                ->references('id')
                ->on('football_teams')
                ->onUpdate('NO ACTION')
                ->onDelete('cascade');

            $table->foreign('league_id')
                ->references('id')
                ->on('leagues')
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
