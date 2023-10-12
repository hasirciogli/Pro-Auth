<?php

namespace Hasirciogli\ProAuth\Models;

use Hasirciogli\Hdb\Database;
use Hasirciogli\ProAuth\Config\DatabaseConfig;

class ClientModel
{
    /**
     * @param string $ClientId
     * @return array|null
     */
    public function GetClient($ClientId): array|null
    {
        return ($Result = Database::cfun(DatabaseConfig::cfun())->Select("clients")->Where("client_id", true)->BindParam("client_id", $ClientId)->Run()->Get()) ? $Result : null;
    }




    /**
     * @param string $ClientId
     * @return string|null
     */
    public function RegenClientSecret($ClientId): string|null
    {
        $NewClientSecret = sha1(random_int(0, 9999999) . time() . time() . time() . time() . time() . time()) . sha1(time() . time() . time() . time() . time() . time());
        return Database::cfun(DatabaseConfig::cfun())->CustomSql("UPDATE clients SET client_secret=:client_secret WHERE client_id=:client_id")
            ->BindParam("client_id", $ClientId)
            ->BindParam("client_secret", $NewClientSecret)
            ->Run() ? $NewClientSecret : null;
    }


    /**
     * @return ClientModel
     */
    public static function cfun(): ClientModel
    {
        return new ClientModel();
    }
}