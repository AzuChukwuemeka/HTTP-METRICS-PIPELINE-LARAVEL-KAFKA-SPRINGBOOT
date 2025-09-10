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
    public function getApiKeyById(string $api_id) : JsonResponse{
        $apiKeyDTO = $this->apiKeyService->getApiKeyById($api_id);
        return response()->json([
            "data" => $apiKeyDTO,
        ]);
    }
    public function getAllApiKeys() : JsonResponse{
        $allApiKeys = $this->apiKeyService->getAllApiKeys();
        return response()->json([
            "data" => $allApiKeys,
        ]);
    }
    public function getAllApiKeysForId(string $user_id) : JsonResponse{
        $allApiKeys = $this->apiKeyService->getAllApiKeysForId($user_id);
        return response()->json([
            "data" => $allApiKeys,
        ]);
    }
    public function activateApiKey(string $api_id): void
    {
        $this->apiKeyService->activateApiKey($api_id);
    }
    public function deactivateApiKey(string $api_id): void
    {
        $this->apiKeyService->deactivateApiKey($api_id);
    }
}
