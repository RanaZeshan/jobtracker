<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobSearchController extends Controller
{
    public function index()
    {
        // Set launch date (you can change this to your desired date)
        $launchDate = '2025-12-01 00:00:00';
        
        return view('jobs.coming-soon', [
            'launchDate' => $launchDate
        ]);
    }
}
