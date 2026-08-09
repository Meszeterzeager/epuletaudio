<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use App\Models\Solution;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order')->get();
        $solutions = Solution::orderBy('order')->get();
        $featuredProjects = Project::with('solution')
            ->latest('completed_at')
            ->take(4)
            ->get();

        return view('home', [
            'services' => $services,
            'solutions' => $solutions,
            'featuredProjects' => $featuredProjects,
        ]);
    }
}
