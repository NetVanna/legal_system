<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /** page account profile */
    public function profileDetail($user_id)
    {
        // Try to find User (Employee) first
        $profileDetail = User::with(['position', 'chapter', 'subChapter'])->find($user_id);
        $type = 'employee';

        if (!$profileDetail) {
            // Try to find Client if User not found
            $profileDetail = \App\Models\Clients::with('instructor')->find($user_id);
            $type = 'client';
        }

        if (!$profileDetail) {
            abort(404);
        }

        // Load related cases based on type
        if ($type === 'employee') {
            $cases = \App\Models\Cases::where('lawyer_id', $user_id)
                ->orWhere('instructor_id', $user_id)
                ->with(['client', 'chapter'])
                ->latest()
                ->get();
            
            $clients = \App\Models\Clients::where('instructor_id', $user_id)->get();
        } else {
            $cases = \App\Models\Cases::where('client_id', $user_id)
                ->with(['lawyer', 'instructor', 'chapter'])
                ->latest()
                ->get();
            $clients = collect(); // Clients don't have "their own" clients in this context
        }

        return view('pages.admin.profile.account-profile', compact('profileDetail', 'type', 'cases', 'clients'));
    }
}
