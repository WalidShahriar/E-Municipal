<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint; // Assuming this is your existing model
use App\Models\ServiceRequest; // Assuming this is your existing model

class AdminDashboardController extends Controller
{
    /**
     * Display the Admin Dashboard and pass the data to the view.
     */
    public function index()
    {
        // 1. Fetch all complaints and add context fields (type, status options)
        $complaints = Complaint::all()->map(function ($item) {
            $item->type = 'Complaint';
            $item->statusOptions = ['Pending', 'In Progress', 'Resolved', 'Closed'];
            return $item;
        });

        // 2. Fetch all service requests and add context fields
        $serviceRequests = ServiceRequest::all()->map(function ($item) {
            $item->type = 'Service Request';
            $item->statusOptions = ['Requested', 'Reviewing/Approved', 'Work in Progress', 'Completed'];
            return $item;
        });

        // 3. Combine and sort the data 
        $dashboardData = $complaints->merge($serviceRequests)->sortByDesc('created_at');

        // IMPORTANT: Use the correct view path: 'pages.admin.dashboard_admin'
        return view('pages.admin.dashboard_admin', [
            'dashboardData' => $dashboardData, // This passes the variable and fixes the error!
        ]);
    }

    /**
     * Handle the AJAX request to update the status of an item.
     */
    public function updateStatus(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string|in:Complaint,Service Request',
            'status' => 'required|string',
        ]);

        // Find the correct model and record based on the 'type'
        if ($request->type == 'Complaint') {
            $record = Complaint::findOrFail($request->id);
        } else {
            $record = ServiceRequest::findOrFail($request->id);
        }

        // Update and save the new status
        $record->status = $request->status;
        $record->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }
}