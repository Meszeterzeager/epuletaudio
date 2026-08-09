<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(9);

        return view('blog.index', ['posts' => $posts]);
    }

    public function show(BlogPost $post)
    {
        return view('blog.show', ['post' => $post]);
    }
}
