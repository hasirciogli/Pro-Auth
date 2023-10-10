<?php
use Hasirciogli\ProAuth\Services\AuthenticateService;
use Hasirciogli\ProAuth\Config\DatabaseConfig;


require_once "vendor/autoload.php";

$as = new AuthenticateService(DatabaseConfig::cfun());

$as->StartService();