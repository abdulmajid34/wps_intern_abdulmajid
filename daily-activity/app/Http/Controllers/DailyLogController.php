<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DailyLogController extends Controller
{
    public function showDashboard()
    {
        return view('dashboard');
    }
}
