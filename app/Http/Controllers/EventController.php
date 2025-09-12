<?php

namespace App\Http\Controllers;

use App\Http\Services\EventService;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private EventService $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * @throws \Exception
     */
    public function registerEvent(Request $request) : JsonResponse{
        $event_type = $request->input('event_type');
        $url = $request->input('url');
        $api_id = $request->header("X-API-KEY");
        $registerEvent = $this->eventService->registerEvent($api_id, $event_type, $url);
        return response()->json($registerEvent);
    }
}
