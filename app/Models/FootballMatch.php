<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $league_id
 * @property boolean $finished
 */
class FootballMatch extends Model
{

    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function league()
    {
        return $this->belongsTo(League::class, 'league_id', 'id');
    }

    public function matchToTeams()
    {
        return $this->hasMany(FootballMatchToTeam::class, 'match_id', 'id');
    }

}
