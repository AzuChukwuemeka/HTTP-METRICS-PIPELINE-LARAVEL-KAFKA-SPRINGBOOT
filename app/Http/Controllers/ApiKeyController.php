<?php

namespace App\Http\Controllers;

use App\Http\DataTransferObjects\ApiKeyDTO;
use App\Http\Services\ApiKeyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Nonstandard\Uuid;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiKeyController extends Controller
{
    private ApiKeyService $apiKeyService;
    public function __construct(ApiKeyService $apiKeyService)
    {
        $this->apiKeyService = $apiKeyService;
    }
    public function createApiKey($name): JsonResponse
    {
        $user_id = auth()->user()->user_id;
        $apiKeyDTO = $this->apiKeyService->createApiKey($user_id, $name);
        return response()->json([
            "apiKey" => $apiKeyDTO,
        ]);
    }
    public function activateApiKey(Request $request): void
    {
        $api_id = $request->input("API_KEY");
        $name = $request->input("API_NAME");
        $this->apiKeyService->updateLastUsedValue($api_id, $name);
    }
    public function deactivateApiKey(Request $request): void
    {
        $api_id = $request->input("API_KEY");
        $name = $request->input("API_NAME");
        $this->apiKeyService->deactivateApiKey($api_id, $name);
    }
}
