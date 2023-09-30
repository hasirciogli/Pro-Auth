<?php
use App\api\ApiV1;
use App\database\MysqlDatabaseService;
use App\servers\AuthorizeServer;
use App\services\AccountService;
use Buki\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require __DIR__ . "/app/Kernel.php";


$router = new Router([
    'paths' => [
        'controllers' => 'app/controllers',
        'middlewares' => 'app/middlewares',
    ],
    'namespaces' => [
        'controllers' => 'App\\controllers',
        'middlewares' => 'App\\middlewares',
    ],
]);

$as = new AuthorizeServer;



$as->Initialize(AccountService::cfun(), MysqlDatabaseService::cfun());
$as->InitializeRoutes($router);


ApiV1::cfun()->run($router);


$router->notFound(function (Request $request, Response $response) {

    $response->headers->set('Content-Type', 'Application/json');

    return $response->setContent(json_encode([
        "status" => false,
        "err" => "invalid request"
    ]));
});



$router->run();

?>