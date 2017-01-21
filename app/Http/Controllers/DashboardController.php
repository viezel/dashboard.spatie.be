<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $pusherKey = config('broadcasting.connections.pusher.key');

        $initialState = (new InitialStateStorage)->getInitialStateForAllComponents();

        return view('dashboard')->with(compact('pusherKey', 'initialState'));
    }
}
