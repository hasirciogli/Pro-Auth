<?php

namespace App\controllers;

use Buki\Router\Http\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserControlPanelController extends Controller
{
    /**
     * @var array Before Middlewares
     */
    public $middlewareBefore = [
        "IsAuthenticated"
    ];

    /**
     * @param Response $response
     */
    public function main(Request $request, Response $response)
    {
        return $response->setContent('Welcome to user control panel dude');
    }
}