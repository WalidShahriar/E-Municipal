<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\ServiceRequest;
use App\Models\Department; // Added for department list
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // -------------------------------------------------------------
        // I. DASHBOARD & ANALYTICS CARDS DATA
        // -------------------------------------------------------------
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();

        $totalServiceRequests = ServiceRequest::count();
        $approvedRequests = ServiceRequest::where('status', 'approved')->count();
        $deniedCount = ServiceRequest::where('status', 'denied')->count(); // For pie chart
        
        // Calculate average resolution time (Example logic)
        $avgResolutionDays = Complaint::where('status', 'resolved')
            // Calculate the difference in days between creation and last update (resolution)
            ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
            ->value('avg_days');
        $avgResolutionDays = round($avgResolutionDays ?? 0, 1);


        // II. DASHBOARD TABLE: Recent Complaints
        // Note: Assumes Complaint Model has a belongsTo relationship with Department Model
        $recentComplaints = Complaint::with('department') // Eager load department name
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($c) {
                // Map the department name correctly for the Blade view
                $c->department_name = $c->department->name ?? 'N/A';
                return $c;
            });

        // III. ANALYTICS CHART DATA

        // 1. Complaints per Department (Chart 1)
        $deptComplaints = DB::table('complaints')
            ->join('departments as d', 'complaints.department_id', '=', 'd.id')
            ->select('d.name', DB::raw('count(*) as count'))
            ->groupBy('d.name')
            ->pluck('count', 'd.name');

        $deptComplaintsLabels = $deptComplaints->keys()->toArray();
        $deptComplaintsCounts = $deptComplaints->values()->toArray();


        // 2. Bi-Annual Trend (Chart 3 - 6 months)
        $trendData = Complaint::select(
                // Formats the date to 'YYYY-MM' for grouping (e.g., '2025-10')
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        
        // 3. Department List (for JavaScript sections)
        $departmentList = Department::select('id', 'name')->get();

        // 4. Placeholder Data for Radar Chart (Department Efficiency)
        // This is complex, so we use dummy data that the JS expects.
        $deptEfficiencyLabels = $departmentList->pluck('name')->toArray();
        // Generate random efficiency data (e.g., 50-100) for each department
        $deptEfficiencyData = $departmentList->map(function() {
            return rand(50, 100); 
        })->toArray();

        // IV. PASS ALL DATA TO THE VIEW
        return view('admin_panel', [
            // Dashboard Cards
            'totalComplaints' => $totalComplaints,
            'pendingComplaints' => $pendingComplaints,
            'resolvedComplaints' => $resolvedComplaints,
            'totalServiceRequests' => $totalServiceRequests,

            // Dashboard Table
            'recentComplaints' => $recentComplaints,

            // Analytics Cards
            'approvedRequests' => $approvedRequests,
            'avgResolutionDays' => $avgResolutionDays,
            
            // Analytics Charts
            'deptComplaintsLabels' => $deptComplaintsLabels,
            'deptComplaintsCounts' => $deptComplaintsCounts,
            'approvedCount' => $approvedRequests,
            'deniedCount' => $deniedCount, // Added denied count
            'complaintTrend' => $trendData,
            'deptEfficiencyLabels' => $deptEfficiencyLabels,
            'deptEfficiencyData' => $deptEfficiencyData,
            
            // Other data for JS sections
            'departmentList' => $departmentList,
        ]);
    }
}