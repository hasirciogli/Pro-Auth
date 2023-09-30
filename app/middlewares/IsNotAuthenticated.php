<?php


namespace App\middlewares;

use Buki\Router\Http\Middleware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IsNotAuthenticated extends Middleware
{
    public function handle(Request $request, Response $response)
    {
        if ($request->headers->get('account_id'))
            return RedirectResponse::create("/ucp");

        return true;
    }
}