<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = ['title',  'description', 'role', 'skills', 'qualifications', 'image', 'employer_id'];
    
    public function employer()
    {
        $jobs = JobPosting::with('employer:id,name')->get();
    }

    public function index()
    {
        // Fetch all job postings
        $jobs = JobPosting::all();
        
        // Pass data to the view
        return view('Employer.dashboard', compact('jobs'));
    }
}
