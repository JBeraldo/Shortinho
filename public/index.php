<?php

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Symfony\Component\Dotenv\Dotenv;
use DI\Bridge\Slim\Bridge;

require __DIR__ . '/../vendor/autoload.php';

$app = Bridge::create();
$twig = Twig::create(__DIR__ . '/../app/Template', ['cache' => false]);

$app->add(TwigMiddleware::create($app, $twig));

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');

require_once __DIR__ . '/../app/Route/route.php';

$app->run();
