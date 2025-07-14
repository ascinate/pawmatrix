<?php

namespace App\Http\Controllers;

use App\Models\SoapTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class SoapTemplateController extends Controller
{
    public function index()
    {
        $templates = SoapTemplate::with('creator')
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action_type' => 'view',
            'description' => 'Viewed SOAP templates list',
            'related_entity' => 'soap_template',
        ]);

        return view('soap_template', compact('templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255|in:general,surgery,dental,vaccination',
            'subjective' => 'required|string',
            'objective' => 'required|string',
            'assessment' => 'required|string',
            'plan' => 'required|string',
        ]);

        $validated['created_by'] = Auth::id();

        $template = SoapTemplate::create($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action_type' => 'create',
            'description' => 'Created SOAP template: ' . $template->name,
            'related_entity' => 'soap_template',
            'related_id' => $template->id,
        ]);

        return redirect()->route('soap-templates.index')
            ->with('success', 'SOAP template created successfully.');
    }

    public function update(Request $request, SoapTemplate $soapTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255|in:general,surgery,dental,vaccination',
            'subjective' => 'required|string',
            'objective' => 'required|string',
            'assessment' => 'required|string',
            'plan' => 'required|string',
        ]);

        $soapTemplate->update($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action_type' => 'update',
            'description' => 'Updated SOAP template: ' . $soapTemplate->name,
            'related_entity' => 'soap_template',
            'related_id' => $soapTemplate->id,
        ]);

        return redirect()->route('soap-templates.index')
            ->with('success', 'SOAP template updated successfully.');
    }

    public function destroy(SoapTemplate $soapTemplate)
    {
        $soapTemplate->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action_type' => 'delete',
            'description' => 'Deleted SOAP template: ' . $soapTemplate->name,
            'related_entity' => 'soap_template',
            'related_id' => $soapTemplate->id,
        ]);

        return redirect()->route('soap-templates.index')
            ->with('success', 'SOAP template deleted successfully.');
    }

    public function getByCategory(Request $request)
    {
        $category = $request->input('category');
        
        $templates = SoapTemplate::where('category', $category)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($templates);
    }

    public function getTemplateContent(Request $request)
    {
        $templateId = $request->input('id');
        
        $template = SoapTemplate::findOrFail($templateId, [
            'name', 'category', 'subjective', 'objective', 'assessment', 'plan'
        ]);

        return response()->json($template);
    }

    public function quickApply(Request $request)
    {
        $templateId = $request->input('template_id');
        $template = SoapTemplate::findOrFail($templateId);

        return response()->json([
            'subjective' => $template->subjective,
            'objective' => $template->objective,
            'assessment' => $template->assessment,
            'plan' => $template->plan,
        ]);
    }
}