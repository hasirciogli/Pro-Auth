<?php

namespace Hasirciogli\ProAuth\Config;

use Hasirciogli\Hdb\Interfaces\Database\Config\DatabaseConfigInterface;

class DatabaseConfig implements DatabaseConfigInterface
{
    const DB_HOST = "localhost";
    const DB_NAME = "proauth";
    const DB_USER = "root";
    const DB_PASS = "1234";

    public static function cfun(): DatabaseConfig
    {
        return new DatabaseConfig;
    }
}