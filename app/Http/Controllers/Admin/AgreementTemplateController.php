<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgreementAuditLog;
use App\Models\AgreementTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AgreementTemplateController extends Controller
{
    public function index()
    {
        $templates = AgreementTemplate::withCount('agreements')->latest()->paginate(10);

        return view('admin.agreements.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.agreements.templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string|max:300',
            'content' => 'required|string',
            'default_payment_terms' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $template = AgreementTemplate::create($validated);

        AgreementAuditLog::log(
            null,
            'template_created',
            "Agreement template '{$template->name}' created by " . Auth::user()->name . "."
        );

        return redirect()->route('admin.agreements.templates.index')
            ->with('success', "Template '{$template->name}' created successfully.");
    }

    public function edit(AgreementTemplate $template)
    {
        return view('admin.agreements.templates.edit', compact('template'));
    }

    public function update(Request $request, AgreementTemplate $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string|max:300',
            'content' => 'required|string',
            'default_payment_terms' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $template->update($validated);

        AgreementAuditLog::log(
            null,
            'template_updated',
            "Agreement template '{$template->name}' updated by " . Auth::user()->name . "."
        );

        return redirect()->route('admin.agreements.templates.index')
            ->with('success', "Template '{$template->name}' updated successfully.");
    }

    public function destroy(AgreementTemplate $template)
    {
        if ($template->agreements()->count() > 0) {
            return back()->with('error', "Cannot delete template '{$template->name}' because it has linked agreements.");
        }

        $name = $template->name;
        $template->delete();

        AgreementAuditLog::log(
            null,
            'template_deleted',
            "Agreement template '{$name}' deleted by " . Auth::user()->name . "."
        );

        return redirect()->route('admin.agreements.templates.index')
            ->with('success', "Template '{$name}' deleted.");
    }
}
