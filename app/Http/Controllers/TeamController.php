<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function show(Team $team)
    {
        return view('teams.show', [
            'team' => $team->load(['league', 'homeFixtures', 'awayFixtures']),
        ]);
    }
} 