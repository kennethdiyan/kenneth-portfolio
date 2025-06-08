<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CertificationController extends Controller
{
    public function index()
    {
        $certifications = Certification::orderBy('issue_date', 'desc')->get();

        return Inertia::render('Admin/Certifications/Index', [
            'certifications' => $certifications
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Certifications/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Certification::create($validated);

        return redirect()->route('admin.certifications.index')
            ->with('success', 'Certification created successfully.');
    }

    public function show(Certification $certification)
    {
        return Inertia::render('Admin/Certifications/Show', [
            'certification' => $certification
        ]);
    }

    public function edit(Certification $certification)
    {
        return Inertia::render('Admin/Certifications/Edit', [
            'certification' => $certification
        ]);
    }

    public function update(Request $request, Certification $certification)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $certification->update($validated);

        return redirect()->route('admin.certifications.index')
            ->with('success', 'Certification updated successfully.');
    }

    public function destroy(Certification $certification)
    {
        $certification->delete();

        return redirect()->route('admin.certifications.index')
            ->with('success', 'Certification deleted successfully.');
    }
}
