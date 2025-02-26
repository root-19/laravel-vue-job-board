<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployerController extends Controller
{
    public function index() 
    {
        return Inertia::render('Employer/Home');
    }
}
