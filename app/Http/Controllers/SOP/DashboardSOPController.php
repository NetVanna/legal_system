<?php

namespace App\Http\Controllers\SOP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardSOPController extends Controller
{
    use \App\Traits\DashboardAnalytics;

    public function index()
    {
        $data = $this->getDashboardData('ស្ដង់ដារអាជីវកម្ម');
        return view('pages.sop.dashboard.index', $data);
    }
}
