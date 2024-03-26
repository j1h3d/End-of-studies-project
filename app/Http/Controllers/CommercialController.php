<?php

namespace App\Http\Controllers;

use App\Models\Commercial;
use App\Models\User;
use Illuminate\Http\Request;

class CommercialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = Commercial::all();

        return response()->json($agents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|integer',
            'password' => 'required|string',
        ]);

        $user = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone'  => $request->phone,
        ]);
        $user->save();

        $agent = new Commercial([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);
        $agent->save();

        return response()->json(['message' => 'Agent created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|integer',
            'email' => 'required|email',
        ]);

        $agent = Commercial::find($id);
        $agent->name = $validatedData['name'];
        $agent->phone = $validatedData['phone'];
        $agent->email = $validatedData['email'];
        $agent->save();

        return response()->json($agent);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agent = Commercial::find($id);

        $agent->delete();
        return response()->json([
            'message' => 'Agent deleted successfully'
        ]);
    }
    public function count()
    {
        $count = Commercial::count();
        return response()->json(['count' => $count]);
    }
}
