<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();

        return response()->json($clients);
    }

    public function show($id)
    {
        $client = Client::with('entreprise')->find($id);
        return response()->json($client);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'phone' => 'required|string',
            'email' => 'required|string',
            'address' => 'required|string'
        ]);

        $client = Client::find($id);
        $client->phone = $validatedData['phone'];
        $client->email = $validatedData['email'];
        $client->address = $validatedData['address'];
        $client->save();

        return response()->json($client);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
        ]);

        Client::create($validatedData);

        return response()->json(['message' => 'Client created successfully']);
    }

    public function destroy($id)
    {
        $client = Client::find($id);

        $client->delete();
        return response()->json([
            'message' => 'client deleted successfully'
        ]);
    }
    public function count()
    {
        $count = Client::query()->count();
        return response()->json(['count' => $count]);
    }
}
