<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $city = City::with('state');

            if($request->name) {
                $city = $city->where('name', 'LIKE', '%' . $request->name . '%');
            }

            $city = $city->get();

            return response()->json([
                'status' => true,
                'data' => $city,
            ], 200);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validateCity = Validator::make($request->all(), City::rules());

            if($validateCity->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateCity->errors()
                ], 401);
            }

            $city = City::create([
                'name' => $request->name,
                'state_id' => $request->state_id,
            ]);

            return response()->json([
                'status' => true,
                'data' => $city
            ], 200);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
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

            $city = City::find($id);

            if(!$city) {
                return response()->json([
                    'status' => false,
                    'message' => 'City not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $city
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

            $validateCity = Validator::make($request->all(), City::rules());

            if($validateCity->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateCity->errors()
                ], 401);
            }

            $city = City::find($id);

            if(!$city) {
                return response()->json([
                    'status' => false,
                    'message' => 'City not found'
                ], 404);
            }

            $city->update([
                'name' => $request->name,
                'state_id' => $request->state_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'City successfully updated'
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

            $city = City::find($id);

            if(!$city) {
                return response()->json([
                    'status' => false,
                    'message' => 'City not found'
                ], 404);
            }

            $city->delete();

            return response()->json([
                'status' => true,
                'message' => 'City successfully deleted'
            ], 200);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
        }
    }
}
