<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactInquiry::query();

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $s = \App\Security\UrlValidator::escapeLike((string) $request->input('search'));
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('subject', 'like', "%{$s}%")
                  ->orWhere('message', 'like', "%{$s}%");
            });
        }

        $inquiries = $query->latest()->paginate(10)->withQueryString();

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(ContactInquiry $inquiry)
    {
        if ($inquiry->status === 'new') {
            $inquiry->update(['status' => 'read']);
        }
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, ContactInquiry $inquiry)
    {
        $request->validate([
            'status' => 'required|in:new,read,in_progress,resolved',
            'admin_notes' => 'nullable|string',
        ]);

        $inquiry->update([
            'status' => $request->input('status'),
            'admin_notes' => $request->input('admin_notes', $inquiry->admin_notes),
        ]);

        return back()->with('success', 'Inquiry status updated successfully.');
    }

    public function destroy(ContactInquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted.');
    }
}

