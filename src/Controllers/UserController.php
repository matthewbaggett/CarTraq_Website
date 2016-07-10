<?php

namespace CarTraq\Controllers;

use Monolog\Logger;
use CarTraq\Services\UserService;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends Controller{

    /** @var UserService */
    private $userService;
    /** @var Logger */
    private $logger;

    public function __construct(UserService $userService, Logger $logger)
    {
        $this->userService = $userService;
        $this->logger = $logger;
    }

    public function showLogin(Request $request, Response $response, array $args = [])
    {
        //@todo
    }
    
}