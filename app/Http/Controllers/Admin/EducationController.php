<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::orderBy('start_date', 'desc')->get();

        return Inertia::render('Admin/Education/Index', [
            'educations' => $educations
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Education/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'institution' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'gpa' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'achievements' => 'nullable|array',
            'is_current' => 'boolean',
            'is_active' => 'boolean'
        ]);

        Education::create($validated);

        return redirect()->route('admin.educations.index')
            ->with('success', 'Education created successfully.');
    }

    public function show(Education $education)
    {
        return Inertia::render('Admin/Education/Show', [
            'education' => $education
        ]);
    }

    public function edit(Education $education)
    {
        return Inertia::render('Admin/Education/Edit', [
            'education' => $education
        ]);
    }

    public function update(Request $request, Education $education)
    {
        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'institution' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'gpa' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'achievements' => 'nullable|array',
            'is_current' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $education->update($validated);

        return redirect()->route('admin.educations.index')
            ->with('success', 'Education updated successfully.');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return redirect()->route('admin.educations.index')
            ->with('success', 'Education deleted successfully.');
    }
}
