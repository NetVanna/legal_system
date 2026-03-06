<?php

namespace App\Http\Controllers\Criminal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardCriminalController extends Controller
{
    use \App\Traits\DashboardAnalytics;

    public function index()
    {
        $data = $this->getDashboardData('ព្រហ្មទណ្ឌ');
        return view('pages.criminal.dashboard.index', $data);
    }
}
