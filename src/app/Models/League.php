<?php

namespace App\Models;

use App\Events\LeagueCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 *
 * @property Collection|FootballLeagueToTeam[] $teamResultsInALeague
 */
class League extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => LeagueCreated::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matches()
    {
        return $this->hasMany(FootballMatch::class, 'league_id', 'id');
    }


    public function teams()
    {
        return $this->hasManyThrough(
            FootballTeam::class,
            FootballLeagueToTeam::class,
            'league_id',
            'id',
            'id',
            'team_id'
        );
    }

    public function matchesToTeams()
    {
        return $this->hasManyThrough(
            FootballMatchToTeam::class,
            FootballMatch::class,
            'league_id',
            'id',
            'id',
            'team_id'
        );
    }

    public function teamResultsInALeague()
    {
        return $this->hasMany(FootballLeagueToTeam::class, 'league_id', 'id');
    }
}
