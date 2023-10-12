<?php
use Hasirciogli\ProAuth\Services\AuthenticateService;
use Hasirciogli\ProAuth\Config\DatabaseConfig;


require_once "vendor/autoload.php";

error_reporting(E_ALL);
ini_set("display_error", 1);

$as = new AuthenticateService(DatabaseConfig::cfun());

$as->StartService();