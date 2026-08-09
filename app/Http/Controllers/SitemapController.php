<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Service;
use App\Models\Solution;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create(route('home'))->setPriority(1.0))
            ->add(Url::create(route('services.index'))->setPriority(0.8))
            ->add(Url::create(route('solutions.index'))->setPriority(0.8))
            ->add(Url::create(route('projects.index'))->setPriority(0.7))
            ->add(Url::create(route('about'))->setPriority(0.5))
            ->add(Url::create(route('contact'))->setPriority(0.5))
            ->add(Url::create(route('blog.index'))->setPriority(0.6))
            ->add(Url::create(route('quote.create'))->setPriority(0.9));

        Service::orderBy('order')->get()->each(
            fn (Service $service) => $sitemap->add(
                Url::create(route('services.show', $service))
                    ->setLastModificationDate($service->updated_at)
                    ->setPriority(0.7)
            )
        );

        Solution::orderBy('order')->get()->each(
            fn (Solution $solution) => $sitemap->add(
                Url::create(route('solutions.show', $solution))
                    ->setLastModificationDate($solution->updated_at)
                    ->setPriority(0.7)
            )
        );

        Project::all()->each(
            fn (Project $project) => $sitemap->add(
                Url::create(route('projects.show', $project))
                    ->setLastModificationDate($project->updated_at)
                    ->setPriority(0.6)
            )
        );

        BlogPost::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->get()
            ->each(
                fn (BlogPost $post) => $sitemap->add(
                    Url::create(route('blog.show', $post))
                        ->setLastModificationDate($post->updated_at)
                        ->setPriority(0.5)
                )
            );

        return $sitemap->toResponse(request());
    }
}
