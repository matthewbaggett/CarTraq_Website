<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function (\Slim\Container $container) {
    $settings = $container->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function (\Slim\Container $container) {
    $settings = $container->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

// Database..
$container['database'] = function(\Slim\Container $container){
    $settings = $container->get('settings')['database'];

    // Database Settings
    $dbConfig = array(
        'db_type'     => $settings['technology'],
        'db_hostname' => $settings['hostname'],
        'db_port'     => $settings['port'],
        'db_username' => $settings['username'],
        'db_password' => $settings['password'],
        'db_database' => $settings['database']
    );
    $database = new \Thru\ActiveRecord\DatabaseLayer($dbConfig);
    return $database;
};

$container[\CarTraq\Services\TrackerService::class] = function(\Slim\Container $container){
    $trackerService = new \CarTraq\Services\TrackerService();
    return $trackerService;
};

$container[\CarTraq\Services\UserService::class] = function(\Slim\Container $container){
    return new \CarTraq\Services\UserService();
};

$container[\CarTraq\Controllers\LocationUpdateController::class] = function(\Slim\Container $container){
    return new \CarTraq\Controllers\LocationUpdateController(
        $container->get(\CarTraq\Services\TrackerService::class),
        $container->get("logger")
    );
};

$container[\CarTraq\Controllers\UserController::class] = function(\Slim\Container $container){
    return new \CarTraq\Controllers\UserController(
        $container->get(\CarTraq\Services\UserService::class),
        $container->get("logger")
    );
};