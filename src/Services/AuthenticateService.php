<?php

namespace Hasirciogli\ProAuth\Services;


use Buki\Router\Router;
use Hasirciogli\ProAuth\Controllers\AuthenticateServiceBackendController;


use Hasirciogli\Hdb\Interfaces\Database\Config\DatabaseConfigInterface;
use Hasirciogli\SessionWrapper\Session;

class AuthenticateService
{
    /**
     * @param DatabaseConfigInterface $DatabaseConfig;
     */
    private DatabaseConfigInterface $DatabaseConfig;
    private Session $Session;

    /**
     * @param DatabaseConfigInterface $DatabaseConfig;
     * @param array $ServerConfig = null;
     */
    public function __construct(DatabaseConfigInterface $DatabaseConfig, array $ServerConfig = null)
    {
        $this->DatabaseConfig = $DatabaseConfig;
        $this->Sesion = new Session($DatabaseConfig);
    }

    /**
     * @return void;
     */
    public function StartService(): void
    {
        $router = new Router;

        // For basic GET URI
        AuthenticateServiceBackendController::cfun()->RegisterRoutes($router);
    }
}