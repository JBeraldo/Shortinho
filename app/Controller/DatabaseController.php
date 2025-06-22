<?php

declare(strict_types = 1);

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Facade\Database;

class DatabaseController
{
   private $container;

   // constructor receives container instance
   public function __construct()
   {
   }

   public function up(Request $request, Response $response): Response
   {
        Database::migrateUp();
   }

}