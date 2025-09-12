<?php

namespace App\Http\Services;

use App\Utils\HttpMetricEventTypes;
use Ramsey\Uuid\Uuid;

class EventService
{
    private ApiKeyInfoService $apiKeyInfoService;
    public function __construct(ApiKeyInfoService $apiKeyInfoService)
    {
        $this->apiKeyInfoService = $apiKeyInfoService;
    }

    /**
     * @throws \Exception
     */
    public function registerEvent(string $api_id, string $event_type, string $url) : bool{
        if(!in_array($event_type, HttpMetricEventTypes::all(),true)){
            throw new \Exception("Invalid Event Type");
        }
        $event_id = Uuid::uuid4();
        $event_timestamp = now()->toJSON();
        //Send to kafka
        return true;
    }
}
