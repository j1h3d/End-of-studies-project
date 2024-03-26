<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string',
            // 'phone' => 'required|string',
            'cp_registration' => 'required|string',
            'social_reason' => 'required|string',
            // 'adress' => 'required|string',
            // 'city' => 'required|string',
            // 'pays' => 'required|string',
            // 'admin_id' => 'required',

        ]);

        $user = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone'  => $request->phone,
        ]);
        $user->save();
        $user->assignRole('entreprise');


        $entreprise = new Entreprise([
            'user_id'  => $user->id,
          // 'admin_id'  => $request->admin_id,
            'cp_registration'  => $request->cp_registration,
            'social_reason' => $request->social_reason,
            'adress'  => $request->adress,
            'city' => $request->city,
            'pays'  => $request->pays,

        ]);


        if ($entreprise->save()) {
            return response()->json([
                'user' => $user,
                'entreprise' => $entreprise

            ], 200);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }
    public function show($userId)
    {
        $enterprise = Entreprise::where('user_id', $userId)->first();

        return response()->json($enterprise);
    }
}
