<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Pet;
use App\Models\User;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::with(['pet.client', 'vet', 'attachments'])
            ->latest()
            ->get();
        
        $pets = Pet::with('client')->get();
        $vets = User::where('role', 'vet')->get();
        
        return view('medical_records', [
            'medicalRecords' => $medicalRecords,
            'pets' => $pets,
            'vets' => $vets
        ]);
    }

    public function getAttachments($id)
    {
        $attachments = Attachment::where('record_id', $id)->get();
        return response()->json($attachments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'vet_id' => 'required|exists:users,id',
            'visit_date' => 'required|date',
            'subjective' => 'nullable|string',
            'objective' => 'nullable|string',
            'assessment' => 'nullable|string',
            'plan' => 'nullable|string',
            'custom_fields' => 'nullable|json',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $medicalRecord = MedicalRecord::create($validated);

            if ($request->hasFile('attachments')) {
                $this->handleAttachments($request->file('attachments'), $medicalRecord->id);
            }

            DB::commit();
            return redirect()->route('medical-records.index')
                ->with('success', 'Medical record created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create medical record: ' . $e->getMessage());
        }
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['pet.client', 'vet', 'attachments']);

        $medicalRecords = MedicalRecord::with(['pet.client', 'vet'])->latest()->get();
        $pets = Pet::with('client')->get();
        $vets = User::where('role', 'vet')->get();

        return view('medical_records', [
            'medicalRecord' => $medicalRecord,
            'medicalRecords' => $medicalRecords,
            'pets' => $pets,
            'vets' => $vets,
        ]);
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'vet_id' => 'required|exists:users,id',
            'visit_date' => 'required|date',
            'subjective' => 'nullable|string',
            'objective' => 'nullable|string',
            'assessment' => 'nullable|string',
            'plan' => 'nullable|string',
            'custom_fields' => 'nullable|json',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            'delete_attachments' => 'nullable|array'
        ]);

        DB::beginTransaction();
        try {
            $medicalRecord->update($validated);

            // Handle file deletions
            if ($request->filled('delete_attachments')) {
                $this->deleteAttachments($request->delete_attachments);
            }

            // Handle new file uploads
            if ($request->hasFile('attachments')) {
                $this->handleAttachments($request->file('attachments'), $medicalRecord->id);
            }

            DB::commit();
            return redirect()->route('medical-records.index')
                ->with('success', 'Medical record updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update medical record: ' . $e->getMessage());
        }
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        DB::beginTransaction();
        try {
            // Delete all associated attachments
            $this->deleteAttachments($medicalRecord->attachments->pluck('id')->toArray());
            
            $medicalRecord->delete();
            
            DB::commit();
            return redirect()->route('medical-records.index')
                ->with('success', 'Medical record deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete medical record: '.$e->getMessage());
        }
    }

    private function handleAttachments($files, $recordId)
    {
        $uploadPath = public_path('assets/uploads/medical_docs');
        
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        foreach ($files as $file) {
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $fileName);

            Attachment::create([
                'record_id' => $recordId,
                'file_path' => 'assets/uploads/medical_docs/' . $fileName,
                'file_type' => $file->getClientOriginalExtension(),
                'uploaded_at' => now()
            ]);
        }
    }

    private function deleteAttachments(array $attachmentIds)
    {
        $attachments = Attachment::whereIn('id', $attachmentIds)->get();
        
        foreach ($attachments as $attachment) {
            $filePath = public_path($attachment->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $attachment->delete();
        }
    }
}