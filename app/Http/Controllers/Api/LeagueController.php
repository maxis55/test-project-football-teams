<?php

namespace App\Http\Controllers\Api;

use App\Events\MatchIsFinished;
use App\Events\PlayedAllMatchesInALeague;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\LeagueResource;
use App\Http\Resources\Api\LeagueTeamResultResource;
use App\Http\Resources\Api\MatchWithResultsResource;
use App\Models\FootballMatch;
use App\Models\League;
use App\Repositories\LeagueRepositoryInterface;
use Illuminate\Http\Request;

class LeagueController extends Controller
{

    public function __construct(protected LeagueRepositoryInterface $repository)
    {
    }

    public function index()
    {
        return LeagueResource::collection(League::all());
    }

    public function show(League $league)
    {
        return new LeagueResource($league);
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        if (empty($name)) {
            $name = 'League'.((League::query()->max('id') ?? 0) + 1);
        }
        $league = League::create(['name' => $name]);

        return new LeagueResource($league);
    }

    public function getLeagueStandingAndPredictions(League $league)
    {
        /**
         * @var
         */
        $league
            ->load('teamResultsInALeague.team');

        return [
            'standings' => LeagueTeamResultResource::collection($league->teamResultsInALeague),
            'predictions' => $this->repository->calculateTheOddsOfWinningForTheTeams($league),
        ];
    }

    public function getAllMatchResults(League $league)
    {
        $league->load([
            'matches' => function ($q) {
                $q->where('finished', true);
                $q->with('matchToTeams.team');
            }
        ]);

        return MatchWithResultsResource::collection($league->matches);
    }

    public function runNextWeek(League $league)
    {
        /**
         * @var FootballMatch $nextMatch
         */
        $nextMatch = $league->matches()
            ->where('finished', false)
            ->with('matchToTeams.team')
            ->firstOrFail();
        $nextMatch->runTheMatch();

        MatchIsFinished::dispatch($nextMatch);

        return new MatchWithResultsResource($nextMatch);
    }

    public function playAll(League $league)
    {
        $matches = $league->matches()->where('finished', false)->get();
        foreach ($matches as $match) {
            $match->runTheMatch();
        }
        PlayedAllMatchesInALeague::dispatch($league);

        return ['success' => true];
    }
}
