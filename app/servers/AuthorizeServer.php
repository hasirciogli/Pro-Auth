<?php 


namespace App\servers;
use App\assignments\accountservice\AccountServiceInterface;
use App\assignments\databaseservice\DatabaseServiceInterface;
use Buki\Router\Router;

class AuthorizeServer {
    private AccountServiceInterface $AccountService;
    private DatabaseServiceInterface $DatabaseService;
    public function Initialize(AccountServiceInterface $AccountServiceInterface, DatabaseServiceInterface $DatabaseServiceInterface): void {
        $this->AccountService = $AccountServiceInterface;
        $this->DatabaseService = $DatabaseServiceInterface;
    }

    public function Check() : void {
        
    }

    public function InitializeRoutes(Router $router) : void {
        $router->get("/authenticate", "LoginController@main");
        $router->get("/cp", "UserControlPanelController@main");
    }
}