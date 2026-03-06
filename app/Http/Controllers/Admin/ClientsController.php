<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Clients::with('instructor')->latest()->get();
        $instructors = User::all(); // Get all users as instructors
        // Or if you have a role column: User::where('role', 'instructor')->get();
        return view("pages.admin.clients.index", compact("clients", "instructors"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_code'   => 'required|string|max:255|unique:clients,client_code',
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email|max:255|unique:clients,email',
            'phone'         => 'nullable|string|max:255|unique:clients,phone',
            'address'       => 'nullable|string',
            'gender'        => 'nullable|in:male,female,other',
            'birth_date'    => 'nullable|date',
            'id_card_num'   => 'nullable|string|max:255|unique:clients,id_card_num',
            'client_type'   => 'nullable|in:individual,company',
            'company_name'  => 'nullable|string|max:255',
            'instructor_id' => 'nullable|exists:users,id',
            'notes'         => 'nullable|string',
        ]);

        try {
            Clients::create([
                'client_code'   => $request->client_code,
                'name'          => $request->name,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'address'       => $request->address,
                'gender'        => $request->gender,
                'birth_date'    => $request->birth_date,
                'id_card_num'   => $request->id_card_num,
                'client_type'   => $request->client_type ?? 'individual',
                'company_name'  => $request->company_name,
                'instructor_id' => $request->instructor_id,
                'notes'         => $request->notes,
            ]);

            flash()->success('Client added successfully!');
        } catch (\Exception $e) {
            Log::error('Client Store Error: ' . $e->getMessage());
            flash()->error('Failed to add client. Please try again.');
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $client = Clients::findOrFail($id);

        $request->validate([
            'client_code'   => 'required|string|max:255|unique:clients,client_code,' . $client->id,
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email|max:255|unique:clients,email,' . $client->id,
            'phone'         => 'nullable|string|max:255|unique:clients,phone,' . $client->id,
            'address'       => 'nullable|string',
            'gender'        => 'nullable|in:male,female,other',
            'birth_date'    => 'nullable|date',
            'id_card_num'   => 'nullable|string|max:255|unique:clients,id_card_num,' . $client->id,
            'client_type'   => 'nullable|in:individual,company',
            'company_name'  => 'nullable|string|max:255',
            'instructor_id' => 'nullable|exists:users,id',
            'notes'         => 'nullable|string',
        ]);

        try {
            $client->update([
                'client_code'   => $request->client_code,
                'name'          => $request->name,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'address'       => $request->address,
                'gender'        => $request->gender,
                'birth_date'    => $request->birth_date,
                'id_card_num'   => $request->id_card_num,
                'client_type'   => $request->client_type ?? 'individual',
                'company_name'  => $request->company_name,
                'instructor_id' => $request->instructor_id,
                'notes'         => $request->notes,
            ]);

            flash()->success('Client updated successfully!');
        } catch (\Exception $e) {
            Log::error('Client Update Error: ' . $e->getMessage());
            flash()->error('Failed to update client. Please try again.');
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $client = Clients::findOrFail($id);
            $client->delete();

            flash()->success('Client deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Client Delete Error: ' . $e->getMessage());
            flash()->error('Failed to delete client. Please try again.');
        }
        return redirect()->back();
    }
}
