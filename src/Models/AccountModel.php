<?php

namespace Hasirciogli\ProAuth\Models;

use Hasirciogli\Hdb\Database;
use Hasirciogli\ProAuth\Config\DatabaseConfig;

class AccountModel
{
    /**
     * @param string $ClientId
     * @return array|null
     */
    public function GetAccount($Email, $Password): array|null
    {
        return ($Result = Database::cfun(DatabaseConfig::cfun())->Select("accounts")
            ->Where("account_email", true)
            ->Where("account_password", true)
            ->BindParam("account_email", $Email)
            ->BindParam("account_password", $Password)
            ->Run()->Get()) ? $Result : null;
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
     * @return AccountModel
     */
    public static function cfun(): AccountModel
    {
        return new AccountModel();
    }
}