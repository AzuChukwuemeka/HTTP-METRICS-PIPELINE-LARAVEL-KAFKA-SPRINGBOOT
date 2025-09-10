<?php

namespace App\Http\Repositories;

use App\Http\DataTransferObjects\ApiKeyDTO;
use Ramsey\Uuid\Nonstandard\Uuid;

interface ApiKeyRepositoryI
{
    public function createApiKey(string $user_id, string $name) : ApiKeyDTO;
    public function getApiKeyByIdAndName(string $api_key) : ApiKeyDTO;
    public function updateLastUsedValue(string $api_key) : void;
    public function deactivateApiKey(string $api_id) : void;
    public function activateApiKey(string $api_id) : void;
}
