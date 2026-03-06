<?php

namespace App\Http\Controllers\BusinessProtection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardBusinessProtectionController extends Controller
{
    use \App\Traits\DashboardAnalytics;

    public function index()
    {
        $data = $this->getDashboardData('អាជីវកម្មឯកជន');
        return view('pages.business_protection.dashboard.index', $data);
    }
}
