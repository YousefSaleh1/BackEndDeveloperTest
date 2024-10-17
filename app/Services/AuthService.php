<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Registers a new user in the system.
     *
     * @param array $data User registration data (name, email, password).
     * @return User Returns the created user instance.
     * @throws HttpResponseException If user creation fails.
     */
    public function register(array $data)
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            // Create a token for the user and return it
            $token = $user->createToken($user->email)->plainTextToken;

            return ['user' => $user, 'token' => $token];
        } catch (\Exception $e) {
            // Log the error message for debugging purposes
            Log::error('User registration failed: ' . $e->getMessage());
            // Throw an exception with a failed response
            throw new HttpResponseException(ApiResponseService::errorResponse('User registration failed', 500));
        }
    }

    /**
     * Logs in a user.
     *
     * @param array $data User login data (email, password).
     * @return array Returns an array containing the user and authentication token.
     * @throws HttpResponseException If the login credentials are incorrect.
     */
    public function login(array $data)
    {
        // Retrieve the user by email
        $user = User::where('email', $data['email'])->first();

        // Verify the password
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new HttpResponseException(ApiResponseService::errorResponse('The provided credentials are incorrect.', 401));
        }

        // Create a token for the user and return it
        $token = $user->createToken($user->email)->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    /**
     * Logs out the authenticated user by revoking all tokens.
     *
     * @param User $user The authenticated user.
     * @return void
     */
    public function logout($user)
    {
        // Revoke all tokens associated with the user
        $user->tokens()->delete();
    }
}
