<?php


namespace App\middlewares;

use Buki\Router\Http\Middleware;
use Symfony\Component\HttpFoundation\Request;

class CsrfToken extends Middleware
{
    public function handle(Request $request)
    {
        return $request->headers->get('csrf-token') == $request->getSession()->get('csrf-token');
    }

}