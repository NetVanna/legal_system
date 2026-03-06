<?php

namespace App\Http\Controllers\Outcourt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardOutcourtController extends Controller
{
    use \App\Traits\DashboardAnalytics;

    public function index()
    {
        $data = $this->getDashboardData('Outcourt');
        return view('pages.outcourt.dashboard.index', $data);
    }
}
