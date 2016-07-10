<?php

namespace CarTraq\Controllers;

use Interop\Container\ContainerInterface;
use Monolog\Logger;
use CarTraq\Services\TrackerService;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class LocationUpdateController extends Controller{

    /** @var TrackerService */
    private $trackerService;
    /** @var Logger */
    private $logger;

    public function __construct(TrackerService $trackerService, Logger $logger)
    {
        $this->trackerService = $trackerService;
        $this->logger = $logger;
    }

    public function doUpdate(Request $request, Response $response, array $args = [])
    {
        $body = $request->getBody()->getContents();
        $body = json_decode($body);
        $this->logger->info("Alive! Device {$body->hardware_id} has checked in.");

        $tracker = $this->trackerService->findTrackerByHardwareId($body->hardware_id);
        $beat = $this->trackerService->beat($tracker);
        if(isset($body->volts)) {
            $beat->volts = intval($body->volts) / 1000;
        }
        if(isset($body->heap)) {
            $beat->heap = intval($body->heap);
        }
        if(isset($body->firmware)) {
            $beat->firmware = $body->firmware;
        }

        $beat->ip_address = $request->getServerParams()['REMOTE_ADDR'];
        $beat->save();

        $this->jsonResponse([
            'Status' => 'Okay',
            'HeartbeatInterval' => 10
        ], $request, $response);
    }
}