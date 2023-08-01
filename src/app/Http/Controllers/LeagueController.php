<?php

namespace App\Http\Controllers;

use App\Models\League;
use Inertia\Inertia;

class LeagueController extends Controller
{
    public function show(League $league)
    {
        return Inertia::render('Football/LeaguePage', [
            'league' => $league,
        ]);
    }
}
