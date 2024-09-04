<?php

namespace App\Services;

use App\Models\User;

class UserRegistrationService
{
    public function __construct(protected LinkService $linkService)
    {
    }

    public function register(array $validatedData)
    {
        $user = User::create([
            'username' => $validatedData['username'],
            'phone_number' => $validatedData['phone_number'],
        ]);

        return $this->linkService->createLink($user->id);
    }
}
