<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactInfoController extends Controller
{
    public function index()
    {
        $contactInfos = ContactInfo::orderBy('sort_order')->get();

        return Inertia::render('Admin/ContactInfo/Index', [
            'contactInfos' => $contactInfos
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/ContactInfo/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'href' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        ContactInfo::create($validated);

        return redirect()->route('admin.contact-info.index')
            ->with('success', 'Contact information created successfully.');
    }

    public function show(ContactInfo $contactInfo)
    {
        return Inertia::render('Admin/ContactInfo/Show', [
            'contactInfo' => $contactInfo
        ]);
    }

    public function edit(ContactInfo $contactInfo)
    {
        return Inertia::render('Admin/ContactInfo/Edit', [
            'contactInfo' => $contactInfo
        ]);
    }

    public function update(Request $request, ContactInfo $contactInfo)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'href' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $contactInfo->update($validated);

        return redirect()->route('admin.contact-info.index')
            ->with('success', 'Contact information updated successfully.');
    }

    public function destroy(ContactInfo $contactInfo)
    {
        $contactInfo->delete();

        return redirect()->route('admin.contact-info.index')
            ->with('success', 'Contact information deleted successfully.');
    }
}
