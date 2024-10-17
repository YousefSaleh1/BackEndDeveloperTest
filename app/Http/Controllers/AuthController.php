<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\ApiResponseService;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $AuthService;

    /**
     * AuthController constructor.
     *
     * Initializes the AuthService instance which handles business logic related to authentication.
     *
     * @param AuthService $AuthService The service responsible for handling authentication.
     */
    public function __construct(AuthService $AuthService)
    {
        $this->AuthService = $AuthService;
    }

    /**
     * Registers a new user.
     *
     * @param RegisterRequest $request The request containing user registration data.
     * @return \Illuminate\Http\JsonResponse Returns a success response with the registered user.
     */
    public function register(RegisterRequest $request)
    {
        $registerResult = $this->AuthService->register($request->validated());

        return ApiResponseService::apiResponse(new UserResource($registerResult['user']), $registerResult['token'], 'User registered successfully', 200);
    }

    /**
     * Logs in a user.
     *
     * @param LoginRequest $request The request containing login credentials.
     * @return \Illuminate\Http\JsonResponse Returns a success response with user and token data.
     */
    public function login(LoginRequest $request)
    {
        $loginResult = $this->AuthService->login($request->validated());

        return ApiResponseService::apiResponse(new UserResource($loginResult['user']), $loginResult['token'], 'Login successful', 200);
    }

    /**
     * Logs out the authenticated user.
     *
     * @param Request $request The request containing the authenticated user.
     * @return \Illuminate\Http\JsonResponse Returns a success response after logging out.
     */
    public function logout(Request $request)
    {
        $this->AuthService->logout($request->user());

        return ApiResponseService::successResponse(null, 'Logged out successfully');
    }
}
