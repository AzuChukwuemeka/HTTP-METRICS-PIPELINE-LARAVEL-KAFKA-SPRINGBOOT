<?php

namespace App\Http\Controllers;

use App\Http\Services\ApiKeyInfoService;
use Illuminate\Http\Request;

class ApiKeyInfo extends Controller
{
    private ApiKeyInfoService $apiKeyInfoService;
    public function __construct(ApiKeyInfoService $apiKeyInfoService){
        $this->apiKeyInfoService = $apiKeyInfoService;
    }
    public function insertApiKeyLog(){
        $api_id = request()->input('api_id');
        $event_type = request()->input('event_type');
        $endpoint = request()->input('endpoint');
        $status_code = request()->input('status_code');
        $this->apiKeyInfoService->insertApiKeyLog($api_id, $event_type, $endpoint, $status_code);
    }
    public function getApiKeyLogForIdPaginated(): array{
        $id = request()->input('api_id');
        $pagenumber = request()->query('pagenumber') ?? 1;
        return $this->apiKeyInfoService->getApiKeyLogForIdPaginated($id, $pagenumber);
    }
}
