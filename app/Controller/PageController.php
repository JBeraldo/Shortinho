<?php

declare(strict_types = 1);

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Views\Twig;

class PageController
{
   private $container;

   // constructor receives container instance
   public function __construct()
   {
   }

   public function index(Request $request, Response $response): Response
   {
        $view = Twig::fromRequest($request);
    
        return $view->render($response, 'Create/index.html.twig');

   }

}
