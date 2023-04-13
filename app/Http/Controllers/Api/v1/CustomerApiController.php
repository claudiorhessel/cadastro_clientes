<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $customer = Customer::paginate();

            return response()->json([
                'status' => true,
                'data' => $customer,
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
            $validateCustomer = Validator::make($request->all(), Customer::rulesStore());

            if($validateCustomer->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateCustomer->errors()
                ], 401);
            }

            $customer = Customer::create([
                'full_name' => $request->full_name,
                'cpf' => $request->cpf,
                'birtdate' => $request->birtdate,
                'gender' => $request->gender,
            ]);

            return response()->json([
                'status' => true,
                'data' => $customer
            ], 200);
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

            $customer = Customer::find($id);

            if(!$customer) {
                return response()->json([
                    'status' => false,
                    'message' => 'Customer not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $customer
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

            $validateCustomer = Validator::make($request->all(), Customer::rulesUpdate($id));

            if($validateCustomer->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateCustomer->errors()
                ], 401);
            }

            $customer = Customer::find($id);

            if(!$customer) {
                return response()->json([
                    'status' => false,
                    'message' => 'Customer not found'
                ], 404);
            }

            $customer->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Customer successfully updated'
            ], 201);
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

            $customer = Customer::find($id);

            if(!$customer) {
                return response()->json([
                    'status' => false,
                    'message' => 'Customer not found'
                ], 404);
            }

            $customer->delete();

            return response()->json([
                'status' => true,
                'message' => 'Customer successfully deleted'
            ], 200);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
        }
    }
}
