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
        $beat->latitude = $body->latitude;
        $beat->longitude = $body->longitude;
        $beat->speed = $body->speed;

        $beat->save();

        $this->jsonResponse([
            'Status' => 'Okay',
            'Beat' => $beat,
        ], $request, $response);
    }
}