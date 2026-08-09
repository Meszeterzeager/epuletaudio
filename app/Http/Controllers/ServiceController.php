<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order')->get();

        return view('services.index', ['services' => $services]);
    }

    public function show(Service $service)
    {
        return view('services.show', ['service' => $service]);
    }
}
