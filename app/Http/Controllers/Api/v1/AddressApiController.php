<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $address = Address::with('customer', 'state', 'city');

            if($request->address) {
                $address = $address->where('address', 'LIKE', '%' . $request->address . '%');
            }

            $address = $address->paginate();

            return response()->json([
                'status' => true,
                'data' => $address,
            ], 200);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        try {
            $validateAddress = Validator::make($request->all(), Address::rulesStore());

            if($validateAddress->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateAddress->errors()
                ], 401);
            }

            $address = Address::create([
                'address' => $request->address,
                'customer_id' => $request->customer_id,
                'city_id' => $request->city_id,
                'state_id' => $request->state_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Address successfully created',
                'data' => $address
            ], 201);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => '"id" must by a number'
                ], 401);
            }

            $address = Address::with('customer', 'state', 'city');
            $address = $address->find($id);

            if(!$address) {
                return response()->json([
                    'status' => false,
                    'message' => 'Address not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $address
            ], 200);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => '"id" must by a number'
                ], 401);
            }

            $validateAddress = Validator::make($request->all(), Address::rulesUpdate($id));

            if($validateAddress->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateAddress->errors()
                ], 401);
            }

            $address = Address::find($id);

            if(!$address) {
                return response()->json([
                    'status' => false,
                    'message' => 'Address not found'
                ], 404);
            }

            $address->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Address successfully updated',
                'data' => $address
            ], 200);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => '"id" must by a number'
                ], 401);
            }

            $address = Address::find($id);

            if(!$address) {
                return response()->json([
                    'status' => false,
                    'message' => 'Address not found'
                ], 404);
            }

            $address->delete();

            return response()->json([
                'status' => true,
                'message' => 'Address successfully deleted'
            ], 200);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
        }
    }
}
