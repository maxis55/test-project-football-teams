<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class FootballController extends Controller
{
    public function index()
    {
        $leagues = League::all()->toArray();


        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'leagues' => $leagues,
        ]);
    }
}
