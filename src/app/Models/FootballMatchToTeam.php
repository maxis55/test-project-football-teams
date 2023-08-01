<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $match_id
 * @property int $team_id
 * @property int $goals
 * @property boolean $is_team_stadium_owner
 *
 */
class FootballMatchToTeam extends Model
{
    use HasFactory;

    protected $fillable = ['match_id', 'team_id', 'goals', 'is_team_stadium_owner'];

    public function team()
    {
        return $this->belongsTo(FootballTeam::class, 'team_id', 'id');
    }

    public function match()
    {
        return $this->belongsTo(FootballMatch::class, 'match_id', 'id');
    }

}
