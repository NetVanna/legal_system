<?php

namespace App\Http\Controllers\FamilyProtection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardFamilyProtectionController extends Controller
{
    use \App\Traits\DashboardAnalytics;

     public function index()
    {
        $data = $this->getDashboardData('Protection Family');
        return view('pages.family_protection.dashboard.index', $data);
    }
}
