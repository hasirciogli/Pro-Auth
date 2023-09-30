<?php

namespace App\controllers;

use App\views\View;
use Buki\Router\Http\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * @var array Before Middlewares
     */
    public $middlewareBefore = [
        "IsNotAuthenticated"
    ];

    /**
     * @param Response $response
     */
    public function main(Request $request, Response $response)
    {
        return View::cfun("LoginPage");
    }
}