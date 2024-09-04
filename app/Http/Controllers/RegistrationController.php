<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserRegistrationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{

    public function __construct(protected UserRegistrationService $registrationService)
    {
    }

    public function register(UserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        try {
            DB::beginTransaction();

            $link = $this->registrationService->register($request->all());

            DB::commit();

            return response()->json([
                'message' => 'User registered successfully',
                'link' => url('/link/' . $link->token),
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Registration error: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred during registration',
            ], 500);
        }
    }
}
