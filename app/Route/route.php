<?php

use App\Controller\{PageController, RedirectController};
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/store', [PageController::class, 'index']);
$app->post('/store', [RedirectController::class, 'store']);