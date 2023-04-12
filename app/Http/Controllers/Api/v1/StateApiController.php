<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StateApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $state = State::paginate();

            return response()->json([
                'status' => true,
                'data' => $state,
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
            $validateState = Validator::make($request->all(), State::rules());

            if($validateState->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateState->errors()
                ], 401);
            }

            $address = State::create([
                'name' => $request->name,
                'abbr' => $request->abbr,
            ]);

            return response()->json([
                'status' => true,
                'data' => $address
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

            $state = State::find($id);

            if(!$state) {
                return response()->json([
                    'status' => false,
                    'message' => 'State not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $state
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

            $validateState = Validator::make($request->all(), State::rules());

            if($validateState->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateState->errors()
                ], 401);
            }

            $state = State::find($id);

            if(!$state) {
                return response()->json([
                    'status' => false,
                    'message' => 'State not found'
                ], 404);
            }

            $state->update([
                'name' => $request->name,
                'abbr' => $request->abbr,
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
    public function destroy(string $id): JsonResponse
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => '"id" must by a number'
                ], 401);
            }

            $state = State::find($id);

            if(!$state) {
                return response()->json([
                    'status' => false,
                    'message' => 'State not found'
                ], 404);
            }

            $state->delete();

            return response()->json([
                'status' => true,
                'message' => 'State successfully deleted'
            ], 200);
        } catch (\Throwable $error) {
            return $this->errorMessage($error);
        }
    }
}
