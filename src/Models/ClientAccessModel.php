<?php

namespace Hasirciogli\ProAuth\Models;

use Hasirciogli\Hdb\Database;
use Hasirciogli\ProAuth\Config\DatabaseConfig;

class ClientAccessModel
{
    public function CanClientAccessToAccount($ClientId, $AccountId): bool
    {
        return Database::cfun(DatabaseConfig::cfun())->Select("clients_accesses")
            ->Where("client_id", true)
            ->Where("account_id", true)
            ->BindParam("client_id", $ClientId)
            ->BindParam("account_id", $AccountId)
            ->Run()->Get() ? true : false;
    }

    public function AddClientAccessToAccount($ClientId, $AccountId): bool
    {
        return Database::cfun(DatabaseConfig::cfun())->Insert("clients_accesses", [
            "client_id",
            "account_id",
        ])
            ->BindParam("client_id", $ClientId)
            ->BindParam("account_id", $AccountId)
            ->Run() ? true : false;
    }


    /**
     * @return ClientAccessModel
     */
    public static function cfun(): ClientAccessModel
    {
        return new ClientAccessModel();
    }
}