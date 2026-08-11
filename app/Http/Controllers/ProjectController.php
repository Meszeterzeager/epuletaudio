<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Setting;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectController extends Controller
{
    public function index()
    {
        $this->ensureReferencesEnabled();

        $projects = Project::with('solution')
            ->where('is_active', true)
            ->latest('completed_at')
            ->paginate(12);

        return view('projects.index', ['projects' => $projects]);
    }

    public function show(Project $project)
    {
        $this->ensureReferencesEnabled();

        if (! $project->is_active) {
            throw new NotFoundHttpException;
        }

        $project->load(['solution', 'images']);

        return view('projects.show', ['project' => $project]);
    }

    private function ensureReferencesEnabled(): void
    {
        if (! Setting::getBool('references_enabled')) {
            throw new NotFoundHttpException;
        }
    }
}
