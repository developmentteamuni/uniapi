<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class LegalController extends Controller
{
    public function index()
    {
        return Inertia::render('Legal');
    }
}