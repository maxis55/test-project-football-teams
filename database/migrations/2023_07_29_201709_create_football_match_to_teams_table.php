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
        Schema::create('football_match_to_teams', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('team_id');

            $table->tinyInteger('goals');

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onUpdate('NO ACTION')
                ->onDelete('cascade');

            $table->foreign('match_id')
                ->references('id')
                ->on('football_matches')
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
        Schema::dropIfExists('football_match_to_teams');
    }
};
