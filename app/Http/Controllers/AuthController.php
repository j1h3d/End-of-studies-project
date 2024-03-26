<?php

namespace App\Http\Controllers;

use App\Models\Commercial;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\EntrepriseController;
use Validator;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @return [string] phone
     * @return [string] message
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|unique:users',
            // 'phone' => 'required|string'
        ]);

        $user = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // 'phone'  => $request->phone,
        ]);






        if ($user->save()) {
            if ($request->role === 'entreprise') {
                // Assign role
                $user->assignRole('entreprise');
                // $this->storeEntreprise($user);
            }
            if ($request->role === 'commercial') {
                // Assign role
                $user->assignRole('commercial');
                // $this->storeCommercial($user);
            }
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'message' => 'Successfully created user!',
                'accessToken' => $token,'user' => $user

            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }
    public function storeEntreprise($user)
    {
        // dd($user);
        $entreprise = Entreprise::create(
            [
                'user_id' => $user->id,
                'cp_registration' => $user->cp_registration,
                'social_reason' => $user->social_reason,
                'adress' => $user->adress,
                'city' => $user->city,
                'pays' => $user->pays,
            ]
        );
        // $var = new EntrepriseController();
        // $content = new Request();
        // $content->admin_id = 1;
        // $content->cp_registration = 2;
        // $content->cp_registration = 2;
    }
    public function storeCommercial($user)
    {
        // dd($user);
        $commercial = Commercial::create(
            [
                'user_id' => $user->id,
                'entreprise_id' => $user->entreprise_id,
                'registration_n' => $user->registration_n,
            ]
        );
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
