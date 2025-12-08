<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ServiceRequest;
use App\Models\User; // Assuming User model for "Total Users"
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // A. Complaints Overview Data
        
        // Total count of all complaints
        $totalComplaints = Complaint::count();
        
        // Complaints created today
        $complaintsToday = Complaint::whereDate('created_at', today())->count();

        // Data for 'Recent Trend (Last 7 Days)' Chart
        // Fetches the count of complaints grouped by the day of creation
        $complaintTrend = Complaint::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();


        // B. Service Requests & User Data

        // Total count of all service requests
        $totalServiceRequests = ServiceRequest::count();
        
        // Service requests created today
        $requestsToday = ServiceRequest::whereDate('created_at', today())->count();

        // Total Users (assuming a standard Laravel User model)
        $totalUsers = User::count(); 

        // Fetch a few recent/pending service requests for the table display
        $recentRequests = ServiceRequest::with('user') // Eager load user if you have a foreign key relationship
            ->where('status', 'Pending') 
            ->latest()
            ->take(5)
            ->get();

        // C. Service Requests Analytics (Grouping)
        $requestsByType = ServiceRequest::select(
                'type',
                DB::raw('count(*) as count')
            )
            ->groupBy('type')
            ->get();
        
        // Prepare data arrays for Chart.js
        $requestLabels = $requestsByType->pluck('type');   // e.g., ['Water Supply', 'Waste Management']
        $requestCounts = $requestsByType->pluck('count'); // e.g., [350, 400]


        // D. Pass Data to the View
        return view('admin_panel', [
            // Overview Counts
            'totalComplaints' => $totalComplaints,
            'complaintsToday' => $complaintsToday,
            'totalServiceRequests' => $totalServiceRequests,
            'requestsToday' => $requestsToday,
            'totalUsers' => $totalUsers, 

            // Trend Chart Data (Pass the raw Collection for processing in JS)
            'complaintTrend' => $complaintTrend, 

            // Service Request Table Data
            'recentRequests' => $recentRequests,

            // Analytics Chart Data
            'requestLabels' => $requestLabels,
            'requestCounts' => $requestCounts,
        ]);
    }
}
