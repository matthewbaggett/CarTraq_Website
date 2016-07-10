<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Render index view
    return $this->renderer->render($response, 'soon/soon.phtml', $args);
});


$app->get('/dashboard', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Dashboard");

    // Render index view
    return $this->renderer->render($response, 'dash/dashboard.phtml', $args);
});

$app->group("/api", function(){
    $this->group("/v1", function(){
        $this->get("/ping", \CarTraq\Controllers\PingController::class . ':doPing');
        $this->group("/track", function(){
            $this->any("/update", \CarTraq\Controllers\LocationUpdateController::class . ':doUpdate');
        });
    });
});