<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::all();

            return response()->json([
                'status' => true,
                'data' => $users
            ], 201);
        } catch (\Throwable $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return User
     */
    public function store(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), User::rules());

            if($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => '"id" must by a number'
                ], 401);
            }

            $user = User::find($id);

            if(!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $user
            ], 200);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => '"id" must by a number'
                ], 401);
            }

            $validateUser = Validator::make($request->all(), User::rules($id));

            if($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::find($id);

            if(!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Status successfully updated'
            ], 201);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => '"id" must by a number'
                ], 401);
            }

            $user = User::find($id);

            if(!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'User successfully deleted'
            ], 200);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
        }
    }
}
