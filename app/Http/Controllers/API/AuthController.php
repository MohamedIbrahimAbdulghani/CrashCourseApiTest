<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request) {
        try {
            // Start of Validation About Request Data
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

    public function register(Request $request) {
        try {
            // Start of Validation About Request Data
            $rules = [
                'name' => 'required',
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
            // to create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            if($user) {
                return $this->login($request);
            }
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request) {
        try {
            // JWTAuth::invalidate($request->token); // Invalidate the JWT token to log out the user
            JWTAuth::parseToken()->invalidate(); // Invalidate the JWT token to log out the user
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ], 200);
        } catch(JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function refresh(Request $request) {
        try {
            $new_token = JWTAuth::refresh($request->token); // Refresh the JWT token to extend its validity
            if($new_token) {
                return response()->json([
                    'success' => true,
                    'message' => 'Token refreshed successfully',
                    'data' => $new_token,
                ]);
            }
        } catch(JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /* ************************************** If I want to use Sanctum to generate token and save it in database  **********************************
        public function register(Request $request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            // create a token for the user
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $user->token = $token;
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        }

    public function login(Request $request) {
            $credentials = $request->only(['email', 'password']); // Extract only the email and password from the request data
            if(Auth::attempt($credentials)) {
                $user = User::where('email', $request->email)->first();
                $token = $user->createToken('Personal Access Token')->plainTextToken;
                $user->token = $token;
                return response()->json([
                    'success' => true,
                    'data' => $user,
                ], 200);
            }
            return response()->json([
                    'success' => false,
                    'message' => 'This Credentials Do Not Match Out Records',
            ], 401);
        }

    public function logout(Request $request) {
        if($request->user()->currentAccessToken()->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ], 200);
        }
        return response()->json([
                'success' => false,
                'message' => 'SomeThing Went Wrong, Please Try Again Later'
            ], 500);
    }
     */

}