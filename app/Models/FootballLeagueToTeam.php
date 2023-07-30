<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $team_id
 * @property int $league_id
 * @property int $points
 * @property int $matches_played
 * @property int $wins
 * @property int $loses
 * @property int $draws
 * @property int $goal_difference
 */
class FootballLeagueToTeam extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'points', 'matches_played', 'wins', 'loses', 'draws', 'goal_difference'];

    public function team()
    {
        return $this->belongsTo(FootballTeam::class, 'team_id', 'id');
    }

    public function league()
    {
        return $this->belongsTo(League::class, 'league_id', 'id');
    }
}
