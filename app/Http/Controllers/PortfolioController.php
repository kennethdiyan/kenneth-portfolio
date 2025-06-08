<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PersonalInfo;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Certification;
use App\Models\ContactInfo;
use App\Models\SocialLink;

class PortfolioController extends Controller
{
    public function index()
    {
        $data = [
            'personalInfo' => PersonalInfo::active()->orderBy('sort_order')->get(),
            'skills' => Skill::active()->orderBy('category')->orderBy('name')->get(),
            'projects' => Project::active()->orderBy('is_featured', 'desc')->orderBy('sort_order')->get(),
            'experiences' => Experience::active()->orderBy('start_date', 'desc')->get(),
            'educations' => Education::active()->orderBy('start_date', 'desc')->get(),
            'certifications' => Certification::active()->orderBy('issue_date', 'desc')->get(),
            'contactInfo' => ContactInfo::active()->orderBy('sort_order')->get(),
            'socialLinks' => SocialLink::active()->orderBy('sort_order')->get(),
        ];

        return Inertia::render('Welcome', $data);
    }
}
