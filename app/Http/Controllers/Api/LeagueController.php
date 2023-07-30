<?php

namespace App\Http\Controllers\Api;

use App\Events\MatchIsFinished;
use App\Events\PlayedAllMatchesInALeague;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\LeagueResource;
use App\Http\Resources\Api\LeagueTeamResult;
use App\Models\FootballMatch;
use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
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

    public function getResults($league)
    {
        /**
         * @var League $leagueModel
         */
        $leagueModel = League::where('id', $league)
            ->withTeamResults()->firstOrFail();
        return LeagueTeamResult::collection($leagueModel->teamResultsInALeague);
    }

    public function runNextWeek(League $league)
    {
        /**
         * @var FootballMatch $nextMatch
         */
        $nextMatch = $league->matches()->where('finished', false)->firstOrFail();
        $nextMatch->runTheMatch();

        MatchIsFinished::dispatch($nextMatch);

        return ['success' => true];
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
