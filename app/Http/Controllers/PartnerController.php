<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::all();

        return response()->json($partners);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'occupation' => 'required|string',
        ]);

        Partner::create($validatedData);

        return response()->json(['message' => 'Partner created successfully']);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'occupation' => 'required|string'
        ]);

        $partner = Partner::find($id);
        $partner->name = $validatedData['name'];
        $partner->phone = $validatedData['phone'];
        $partner->email = $validatedData['email'];
        $partner->occupation = $validatedData['occupation'];
        $partner->save();

        return response()->json($partner);
    }

    public function destroy($id)
    {
        $partner = Partner::find($id);

        $partner->delete();
        return response()->json([
            'message' => 'Partner deleted successfully'
        ]);
    }
    public function count()
    {
        $count = Partner::count();
        return response()->json(['count' => $count]);
    }
}
