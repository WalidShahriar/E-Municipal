<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Str; // We will use this for the unique ID

class ServiceRequestController extends Controller
{
    // Method to handle new request submissions (POST)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string|max:50',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            // Note: File upload logic will be added later
            'department' => 'required|string|max:100',
        ]);

        // --- Logic to Generate Unique SIR-ID (SIR-25-00001) ---
        // In a real app, this should be done carefully to ensure uniqueness and sequence.
        // For a start, we'll find the last ID and increment it.
        $lastRequest = ServiceRequest::latest('id')->first();
        $lastIdNumber = $lastRequest ? (int) substr($lastRequest->request_id, -5) : 0;
        $newIdNumber = $lastIdNumber + 1;
        $year = now()->format('y');
        $requestId = "SIR-{$year}-" . str_pad($newIdNumber, 5, '0', STR_PAD_LEFT);
        // --------------------------------------------------------

        $serviceRequest = ServiceRequest::create([
            'request_id' => $requestId,
            'title' => $validatedData['title'],
            'category' => $validatedData['category'],
            'description' => $validatedData['description'],
            'location' => $validatedData['location'] ?? 'Not Provided',
            'attachment_name' => $request->attachmentName ?? 'N/A', // Using value from JS simulation
            'department' => $validatedData['department'],
            'status' => 'Requested',
            'manager_remarks' => 'Awaiting initial review.',
            'submitted_by' => auth()->id() ?? 'anonymous', // Use Laravel Auth if logged in
        ]);

        return response()->json(['id' => $serviceRequest->request_id, 'message' => 'Request submitted successfully'], 201);
    }

    // Method to handle status tracking (GET)
    public function show($id)
    {
        $request = ServiceRequest::where('request_id', $id)->first();

        if (!$request) {
            return response()->json(['message' => 'Service Request ID not found.'], 404);
        }

        return response()->json($request);
    }
}