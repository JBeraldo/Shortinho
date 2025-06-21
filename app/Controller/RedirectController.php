<?php
namespace App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Views\Twig;

class RedirectController
{
   private $container;

   // constructor receives container instance
   public function __construct()
   {
   }

   public function store(Request $request, Response $response, array $args): Response
   {
        $view = Twig::fromRequest($request);
    
        return $view->render($response, 'Create/response.html.twig', [
            'name' => 'John',
        ]);

   }

}
