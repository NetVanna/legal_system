<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardContractController extends Controller
{
    use \App\Traits\DashboardAnalytics;

    public function index()
    {
        $data = $this->getDashboardData('កិច្ចសន្យា');
        return view('pages.contract.dashboard.index', $data);
    }
}
