<?php

namespace App\Http\Controllers;

use App\Models\Solution;

class SolutionController extends Controller
{
    public function index()
    {
        $solutions = Solution::orderBy('order')->get();

        return view('solutions.index', ['solutions' => $solutions]);
    }

    public function show(Solution $solution)
    {
        $solution->load(['projects' => fn ($query) => $query->with('images')->take(6)]);

        return view('solutions.show', ['solution' => $solution]);
    }
}
