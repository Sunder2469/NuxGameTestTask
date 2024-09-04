<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\LinkService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LinkController extends Controller
{
    public function __construct(protected LinkService $linkService)
    {
    }

    public function show($token)
    {
        $link = $this->linkService->getLinkByToken($token);

        if ($link->expires_at < now()) {
            return response()->json(['message' => 'Link expired'], 404);
        }

        return view('link.show', compact('link'));
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    public function generateNewLink($token): JsonResponse
    {
        try {
            DB::beginTransaction();

            $link = $this->linkService->getLinkByToken($token);
            $newLink = $this->linkService->generateNewLink($link);

            DB::commit();

            return response()->json([
                'new_link' => url('/link/' . $newLink->token),
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Link generation error: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to generate new link'], 500);
        }
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    public function deactivateLink($token): JsonResponse
    {
        try {
            $link = $this->linkService->getLinkByToken($token);
            $this->linkService->deactivateLink($link);

            return response()->json(['message' => 'Link deactivated']);
        } catch (Exception $e) {
            Log::error('Link deactivation error: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to deactivate link'], 500);
        }
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    public function imFeelingLucky($token): JsonResponse
    {
        try {
            DB::beginTransaction();

            $link = $this->linkService->getLinkByToken($token);
            $result = $this->linkService->getLuckyResult($link);

            DB::commit();

            return response()->json($result);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Lucky result error: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to generate lucky result'], 500);
        }
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    public function history($token): JsonResponse
    {
        try {
            $link = $this->linkService->getLinkByToken($token);
            $history = $this->linkService->getHistory($link);

            return response()->json($history);
        } catch (Exception $e) {
            Log::error('History retrieval error: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to retrieve history'], 500);
        }
    }
}
