<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint; // <--- Import the Model

class ComplaintController extends Controller
{
    // Helper function to generate the unique Complaint ID (COMP-YYYY-####)
    private function generateComplaintID(): string
    {
        // Get the current count of complaints and start the ID from 1001
        $count = Complaint::count() + 1001;
        $year = date('Y');
        // Pad the number with leading zeros to four digits
        return "COMP-{$year}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Store a newly created complaint in the database.
     */
    public function store(Request $request)
    {
        // 1. Validation (Ensures required fields are present and safe)
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'description' => 'required|string',
            // location and attachment_name are nullable/optional
        ]);

        // 2. Department Mapping (Copied from your Blade file JS for consistency)
        $departmentMap = [
            'Electricity' => 'Electrical Maintenance',
            'Waste' => 'Sanitation Services',
            'Roads' => 'Public Works Department',
            'Water Supply' => 'Water & Sewage Authority',
            'Public Space' => 'Parks & Recreation',
        ];
        $category = $request->input('category');
        $department = $departmentMap[$category] ?? 'Central Administration';

        // 3. Create the Complaint record in MySQL
        $complaint = Complaint::create([
            'complaint_id' => $this->generateComplaintID(),
            'title' => $request->input('title'),
            'category' => $category,
            'description' => $request->input('description'),
            'location' => $request->input('location') ?? 'Not Provided',
            // We use the temporary name passed from the frontend for now
            'attachment_name' => $request->input('attachment_name') ?? 'N/A', 
            'department' => $department,
            'status' => 'Pending', // Default status upon creation
        ]);

        // 4. Return the new Complaint ID to the frontend for the success modal
        return response()->json([
            'success' => true,
            'id' => $complaint->complaint_id,
        ], 201); // HTTP 201 Created
    }

    /**
     * Display the specified complaint status.
     */
    public function show(string $id)
    {
        // Search the database for the complaint_id
        $complaint = Complaint::where('complaint_id', $id)->first();

        if ($complaint) {
            // Return the full complaint data
            return response()->json([
                'success' => true,
                'complaint' => $complaint,
            ]);
        }

        // Return a 404 error if the ID is not found
        return response()->json([
            'success' => false,
            'message' => "Complaint ID '{$id}' not found.",
        ], 404);
    }
}