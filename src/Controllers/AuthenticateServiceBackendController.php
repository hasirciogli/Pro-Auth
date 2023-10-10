<?php

namespace Hasirciogli\ProAuth\Controllers;

use Buki\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateServiceBackendController
{
    public function RegisterRoutes(Router $Router): void
    {
        $Router->get('/proauth0/authenticate', function (Request $request, Response $response) {
            return $this->Authenticate($request, $response);
        });
    }

    public function Authenticate(Request $request, Response $response): Response
    {
        return $response;
    }
    public static function cfun(): AuthenticateServiceBackendController
    {
        return new AuthenticateServiceBackendController();
    }
}