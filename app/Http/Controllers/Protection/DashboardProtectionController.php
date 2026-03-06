<?php

namespace App\Http\Controllers\Protection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardProtectionController extends Controller
{
    use \App\Traits\DashboardAnalytics;

     public function index()
    {
        $data = $this->getDashboardData('Protection');
        return view('pages.protection.dashboard.index', $data);
    }
}
