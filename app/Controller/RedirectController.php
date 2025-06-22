<?php

declare(strict_types = 1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Service\RedirectService;
use App\Helper\UrlValidator;

use Slim\Views\Twig;


class RedirectController
{
   private RedirectService $service;

   // constructor receives container instance
   public function __construct(RedirectService $service)
   {
        $this->service = $service;
   }

   public function store(Request $request, Response $response): Response
   {
        $view = Twig::fromRequest($request);

        ["url" => $url] = $request->getParsedBody();
        
        if(!UrlValidator::validate($url))
        {
            return $view->render($response, 'Create/response.html.twig', [
                'key' => null,
            ]);
        }

        $key = $this->service->store($url);

        return $view->render($response, 'Create/response.html.twig', [
            'key' => $key,
        ]);
   }

   public function redirect(string $key, Request $request, Response $response): Response
   {
        $view = Twig::fromRequest($request);

        $url = $this->service->getURLbyKey($key);

        if(!$url){
            return $view->render($response, 'Fallback/fallback.html.twig');
        }

        return $response->withHeader('Location', $url)->withStatus(302);
   }

}
