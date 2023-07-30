<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\LeagueResource;
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

    public function create(Request $request)
    {
        $name = $request->input('name');
        if (empty($name)) {
            $name = 'League'.((League::query()->max('id') ?? 0) + 1);
        }
        $league = League::create(['name' => $name]);
        return new LeagueResource($league);

    }
}
