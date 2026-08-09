<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('solution')
            ->latest('completed_at')
            ->paginate(12);

        return view('projects.index', ['projects' => $projects]);
    }

    public function show(Project $project)
    {
        $project->load(['solution', 'images']);

        return view('projects.show', ['project' => $project]);
    }
}
