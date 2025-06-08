<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalInfo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PersonalInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personalInfos = PersonalInfo::orderBy('sort_order')->get();

        return Inertia::render('Admin/PersonalInfo/Index', [
            'personalInfos' => $personalInfos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/PersonalInfo/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        PersonalInfo::create($validated);

        return redirect()->route('admin.personal-info.index')
            ->with('success', 'Personal information created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonalInfo $personalInfo)
    {
        return Inertia::render('Admin/PersonalInfo/Show', [
            'personalInfo' => $personalInfo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalInfo $personalInfo)
    {
        return Inertia::render('Admin/PersonalInfo/Edit', [
            'personalInfo' => $personalInfo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonalInfo $personalInfo)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $personalInfo->update($validated);

        return redirect()->route('admin.personal-info.index')
            ->with('success', 'Personal information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalInfo $personalInfo)
    {
        $personalInfo->delete();

        return redirect()->route('admin.personal-info.index')
            ->with('success', 'Personal information deleted successfully.');
    }
}
