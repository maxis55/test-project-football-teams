<?php

namespace App\Models;

use App\Events\LeagueCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
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

    public function scopeWithTeamResults($q)
    {
        //could replace with an annoying join to avoid nesting (not finished example)
//        ->join((new FootballTeam())->getTable(), (new FootballLeagueToTeam())->getTable().'.team_id',
//        (new FootballTeam())->getTable().'.id')
        //but lazy

        return $q->with('teamResultsInALeague.team');
    }
}
