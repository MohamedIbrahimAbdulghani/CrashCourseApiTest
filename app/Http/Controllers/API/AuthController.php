<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request) {
        try {
            $rules = [
                'email' => 'required',
                'password' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules); // Validate the request data against the defined rules
            if($validator->fails()) { // Check if validation fails
                return response()->json([ // Return a JSON response with validation errors
                    'success' => false,
                    'message' => $validator->errors()
                ], 400);
            }
            $credentials = $request->only(['email', 'password']); // Extract only the email and password from the request data
            $token = Auth::guard("api")->attempt($credentials); // Attempt to authenticate the user using the provided credentials and generate a JWT token
            if(!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Email or Password',
                ], 401);
            }
            $user = Auth::guard("api")->user();
            $user->token = $token;
            return response()->json([
                'success' => true,
                'data' => $user,
            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }
}
