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
        Schema::create('football_match_to_teams', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('team_id');

            $table->tinyInteger('goals')->nullable();
            $table->boolean('is_team_stadium_owner')->default(false);

            $table->foreign('team_id')
                ->references('id')
                ->on('football_teams')
                ->onUpdate('NO ACTION')
                ->onDelete('cascade');

            $table->foreign('match_id')
                ->references('id')
                ->on('football_matches')
                ->onUpdate('NO ACTION')
                ->onDelete('cascade');

            $table->unique(['match_id', 'team_id']);

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
