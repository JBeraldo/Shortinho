<?php

declare(strict_types = 1);

use App\Controller\{PageController, RedirectController, DatabaseController};
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/store', [PageController::class, 'index']);
$app->get('/{key}', [RedirectController::class, 'redirect']);
$app->post('/store', [RedirectController::class, 'store']);

$app->get('/database/up', [DatabaseController::class, 'up']);
