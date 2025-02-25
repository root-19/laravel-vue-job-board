<?php

namespace App\Http\Controllers;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;
// use Inertia\Inertia;
// use Illuminate\Http\Request;

class JobPostingController extends Controller
{
    public function index()
    {
        $jobs = JobPosting::where('employer_id', Auth::id())->get();
        return Inertia::render('Employer/JobPostings', ['jobs' => $jobs]);
    }

    public function create()
    {
        return Inertia::render('Employer/CreateJobPosting');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'role' => 'required|string|max:255',
            'skills' => 'required|string',
            'qualifications' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('job_images', 'public') : null;

        JobPosting::create([
            'employer_id' => Auth::id(),
            'employer_name' => Auth::user()->name,
            'title' => $request->title,
            'description' => $request->description,
            'role' => $request->role,
            'skills' => $request->skills,
            'qualifications' => $request->qualifications,
            'image' => $imagePath,
    
        ]);

        $data = $request->except('image');

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('job_images', 'public');
    }

    $data['employer_id'] = auth()->id(); 
    JobPosting::create($data);

    return redirect()->route('Employer.dashboard')->with('success', 'Job posted successfully!');

    }
  public function allJobs()
{
    $jobs = JobPosting::all(); // Get all job postings
    return Inertia::render('Dashboard', ['jobs' => $jobs]);
}

    
}