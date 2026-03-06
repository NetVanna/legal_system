<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    use \App\Traits\DashboardAnalytics;

    public function index()
    {
        $data = $this->getDashboardData(); // No module key for Admin (sees everything)

        // Additional Admin-Specific Data
        $data['activeUsers'] = DB::table('users')->where('status', 'active')->count();
        $data['inactiveUsers'] = DB::table('users')->where('status', '!=', 'active')->orWhereNull('status')->count();
        $data['totalDepartments'] = DB::table('chapter_departments')->count();
        $data['totalPositions'] = DB::table('positions')->count();
        
        return view('pages.admin.dashboard.home', $data);
    }
}
