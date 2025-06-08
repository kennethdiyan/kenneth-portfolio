<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalInfo;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Certification;
use App\Models\ContactInfo;
use App\Models\SocialLink;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        // Redirect to admin dashboard or show admin home page
        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        $stats = [
            'personal_infos' => PersonalInfo::count(),
            'skills' => Skill::count(),
            'projects' => Project::count(),
            'experiences' => Experience::count(),
            'educations' => Education::count(),
            'certifications' => Certification::count(),
            'contact_infos' => ContactInfo::count(),
            'social_links' => SocialLink::count(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats
        ]);
    }
}
