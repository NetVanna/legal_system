<?php

namespace App\Http\Controllers\IndividualProtection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardIndividualProtectionController extends Controller
{
    use \App\Traits\DashboardAnalytics;

    public function index()
    {
        $data = $this->getDashboardData('Personal Protection');
        return view('pages.individual_protection.dashboard.index', $data);
    }
}
