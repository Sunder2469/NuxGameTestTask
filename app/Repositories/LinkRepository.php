<?php

namespace App\Repositories;

use App\Models\Link;

class LinkRepository
{
    public function findActiveByToken($token)
    {
        return Link::where('token', $token)
            ->where('active', true)
            ->firstOrFail();
    }
}
