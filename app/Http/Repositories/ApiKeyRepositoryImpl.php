<?php

namespace App\Http\Repositories;

use App\Http\DataTransferObjects\ApiKeyDTO;
use Illuminate\Database\ConnectionInterface;
use Ramsey\Uuid\Nonstandard\Uuid;

class ApiKeyRepository implements ApiKeyRepositoryI
{
    private ConnectionInterface $connection;
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }
    public function createApiKey(string $user_id, string $name): ApiKeyDTO
    {
        $api_id = UUID::uuid4();
        $key = \Str::random(32);
        $expires_at = now()->addYear();
        $last_used_at = null;
        $created_at = now();
        $updated_at = now();

        $this->connection
            ->table("tbl_users")
            ->insert([
                "api_id" => $api_id,
                "user_id" => $user_id,
                "key" => $key,
                "name" => $name,
                "active" => true,
                "last_used_at" => $last_used_at,
                "created_at" => $created_at,
                "updated_at" => $updated_at,
            ]);
        return new ApiKeyDTO($key,$name, $expires_at, $created_at);
    }
    public function getApiKeyByIdAndName(string $api_key): ApiKeyDTO
    {
        // TODO: Implement getApiKeyByIdAndName() method.
    }
    public function updateLastUsedValue(string $api_key): void
    {
        // TODO: Implement updateLastUsedValue() method.
    }
    public function deactivateApiKey(string $api_id): void
    {
        // TODO: Implement deactivateApiKey() method.
    }
    public function activateApiKey(string $api_id): void
    {
        // TODO: Implement activateApiKey() method.
    }
}
