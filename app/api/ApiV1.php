<?php

namespace App\api;

use Buki\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiV1
{

    public function run(Router $r)
    {
        $r->group("/api", function (Router $groupRouter) {

        });

        $r->get("/", function (Request $request, Response $response) {

            return $response->setContent("hello world");
        });

        
    }

    public static function cfun(): ApiV1
    {
        return new ApiV1();
    }
}