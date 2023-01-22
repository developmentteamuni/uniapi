<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class FeaturesController extends Controller
{
    public function index()
    {
        return Inertia::render('Features');
    }
}
