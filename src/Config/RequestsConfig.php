<?php

namespace Hasirciogli\ProAuth\Config;

use Hasirciogli\Hdb\Interfaces\Database\Config\DatabaseConfigInterface;

class RequestsConfig
{
    const RC_ALLOWED_HOSTS = "http://localhost:1167";
    public static function cfun(): RequestsConfig
    {
        return new RequestsConfig;
    }
}