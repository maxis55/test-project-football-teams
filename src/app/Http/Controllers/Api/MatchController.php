<?php

namespace App\Http\Controllers\Api;

use App\Events\MatchResultsHaveChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateMatchResultsRequest;
use App\Http\Resources\Api\MatchWithResultsResource;
use App\Models\FootballMatch;

class MatchController extends Controller
{
    public function updateResults(UpdateMatchResultsRequest $request, FootballMatch $match)
    {
        $match->load('matchToTeams.team');

        $guestTeamId = $request->input('guest_team_id');
        $guestTeamGoals = $request->input('guest_team_goals');
        $homeTeamId = $request->input('home_team_id');
        $homeTeamGoals = $request->input('home_team_goals');
        $match->matchToTeams()->where('team_id', $homeTeamId)->update(['goals' => $homeTeamGoals]);
        $match->matchToTeams()->where('team_id', $guestTeamId)->update(['goals' => $guestTeamGoals]);

        MatchResultsHaveChanged::dispatch($match);

        return new MatchWithResultsResource($match);
    }
}
