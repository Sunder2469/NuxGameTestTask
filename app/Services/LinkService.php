<?php

namespace App\Services;

use App\Models\Link;
use App\Models\LuckyHistory;
use App\Repositories\LinkRepository;
use Illuminate\Support\Str;

class LinkService
{
    public function __construct(protected LinkRepository $linkRepository)
    {
    }

    public function createLink($userId)
    {
        return Link::create([
            'user_id' => $userId,
            'token' => Str::random(32),
            'expires_at' => now()->addDays(7),
        ]);
    }

    public function generateNewLink(Link $link)
    {
        $link->update(['active' => false]);

        return $this->createLink($link->user_id);
    }

    public function deactivateLink(Link $link)
    {
        $link->update(['active' => false]);
    }

    public function getLuckyResult(Link $link)
    {
        $randomNumber = rand(1, 1000);
        $win = $randomNumber % 2 === 0;
        $prize = 0;

        if ($win) {
            if ($randomNumber > 900) {
                $prize = $randomNumber * 0.7;
            } elseif ($randomNumber > 600) {
                $prize = $randomNumber * 0.5;
            } elseif ($randomNumber > 300) {
                $prize = $randomNumber * 0.3;
            } else {
                $prize = $randomNumber * 0.1;
            }
        }

        return LuckyHistory::create([
            'link_id' => $link->id,
            'random_number' => $randomNumber,
            'result' => $win ? 'Win' : 'Lose',
            'prize' => $prize,
        ]);
    }

    public function getHistory(Link $link, $limit = 3)
    {
        return $link->history()->latest()->take($limit)->get();
    }

    public function getLinkByToken($token)
    {
        return $this->linkRepository->findActiveByToken($token);
    }
}
