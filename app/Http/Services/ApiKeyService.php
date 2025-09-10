<?php

namespace App\Http\Services;

use App\Exceptions\ApiExpiredException;
use App\Http\DataTransferObjects\ApiKeyDTO;
use App\Http\Repositories\ApiKeyRepositoryI;
use Ramsey\Uuid\Nonstandard\Uuid;

class ApiKeyService
{
    private ApiKeyRepositoryI $apiKeyRepository;
    public function __construct(ApiKeyRepositoryI $apiKeyRepository)
    {
        $this->apiKeyRepository = $apiKeyRepository;
    }
    public function createApiKey(string $user_id, string $name): ApiKeyDTO
    {
        return $this->apiKeyRepository->createApiKey($user_id, $name);
    }

    /**
     * @throws ApiExpiredException
     */
    public function checkValidityApiKey(string $api_id, string $name): void
    {
        $apiKeyDTO = $this->apiKeyRepository->getApiKeyByIdAndName($api_id, $name);
        if(now() > $apiKeyDTO->getExpiresAt()) throw new ApiExpiredException();
    }
    public function updateLastUsedValue(string $api_id, $name): void
    {
        $this->apiKeyRepository->updateLastUsedValue($api_id, $name);
    }
    public function activateApiKey(string $api_id, $name): void
    {
        $this->apiKeyRepository->updateLastUsedValue($api_id, $name);
    }
    public function deactivateApiKey(string $api_id, $name): void
    {
        $this->apiKeyRepository->deactivateApiKey($api_id, $name);
    }
}
