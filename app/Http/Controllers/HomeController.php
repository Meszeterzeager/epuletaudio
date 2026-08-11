<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Solution;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order')->get();
        $solutions = Solution::orderBy('order')->get();
        $featuredProjects = Setting::getBool('references_enabled')
            ? Project::with('solution')->where('is_active', true)->latest('completed_at')->take(4)->get()
            : new Collection;

        return view('home', [
            'services' => $services,
            'solutions' => $solutions,
            'featuredProjects' => $featuredProjects,
        ]);
    }
}
