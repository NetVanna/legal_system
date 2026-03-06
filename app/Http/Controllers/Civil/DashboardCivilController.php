<?php

namespace App\Http\Controllers\Civil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardCivilController extends Controller
{
    use \App\Traits\DashboardAnalytics;

    public function index()
    {
        $data = $this->getDashboardData('រដ្ឋប្បវេណី');
        return view('pages.civil.dashboard.index', $data);
    }
}
