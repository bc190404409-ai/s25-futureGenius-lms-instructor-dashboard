<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificationController extends Controller
{
    use AuthorizesRequests;
    // List all certifications of the instructor
    public function index()
    {
        $certifications = Auth::user()->certifications()->latest()->get();
        return view('instructor.certifications.index', compact('certifications'));
    }

    // Show form to create a certification
    public function create()
    {
        return view('instructor.certifications.create');
    }

    // Store new certification
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'status' => 'required|in:pending,approval',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('certifications', 'public');
        }

        Certification::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'issuer' => $validated['issuer'],
            'file' => $filePath,
            'issue_date' => $validated['issue_date'],
            'expiry_date' => $validated['expiry_date'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('certifications.index')->with('success', 'Certification added successfully.');
    }


    // Show edit form
    public function edit(Certification $certification)
    {
        if ($certification->instructor_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('instructor.certifications.edit', compact('certification'));
    }

    // Update certification
    public function update(Request $request, Certification $certification)
    {
        if ($certification->instructor_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $status = 'pending';

        if ($request->has('status')) {
            if ($request->status === 'approval') {
                $status = 'approval';
            } else {
                $status = 'pending';
            }
        }

        $validated =  $request->validate([
            'title' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'status' => 'required|in:pending,approval',
        ]);

        if ($request->hasFile('file')) {
            if (Storage::disk('public')->exists($certification->file_path)) {
                Storage::disk('public')->delete($certification->file_path);
            }
            $certification->file_path = $request->file('file')->store('certifications', 'public');
        }

        $certification->update([
            'title' => $validated['title'],
            'issuer' => $request->issuer,
            'issue_date' => $request->issue_date,
            'expiry_date' => $request->expiry_date,
            'status' => $status,
        ]);

        return redirect()->route('certifications.index')->with('success', 'Certification updated successfully.');
    }

    // Delete certification
    public function destroy(Certification $certification)
    {
        if ($certification->instructor_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (Storage::disk('public')->exists($certification->file_path)) {
            Storage::disk('public')->delete($certification->file_path);
        }

        $certification->delete();
        return redirect()->route('certifications.index')->with('success', 'Certification deleted successfully.');
    }
}
