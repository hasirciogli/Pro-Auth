<?php

namespace Hasirciogli\ProAuth\Models;

use Hasirciogli\Hdb\Database;
use Hasirciogli\ProAuth\Config\DatabaseConfig;

class TokenModel
{
    public function IsTokenExists($TokenType, $Token): bool
    {
        switch ($TokenType) {
            case "access":
                return Database::cfun(DatabaseConfig::cfun())->Select("access_tokens")->Where("token", true)->BindParam("token", $Token)->Run()->Get() ? true : false;
            case "refresh":
                return Database::cfun(DatabaseConfig::cfun())->Select("refresh_tokens")->Where("token", true)->BindParam("token", $Token)->Run()->Get() ? true : false;
            case "authorization":
                return Database::cfun(DatabaseConfig::cfun())->Select("authorization_tokens")->Where("token", true)->BindParam("token", $Token)->Run()->Get() ? true : false;
            default:
                throw new \ErrorException("Invaid Token Type");
        }
    }

    public function GetToken($TokenType, $Token): array|null
    {
        switch ($TokenType) {
            case "access":
                return Database::cfun(DatabaseConfig::cfun())->Select("access_tokens")->Where("token", true)->BindParam("token", $Token)->Run()->Get() ?? null;
            case "refresh":
                return Database::cfun(DatabaseConfig::cfun())->Select("refresh_tokens")->Where("token", true)->BindParam("token", $Token)->Run()->Get() ?? null;
            case "authorization":
                return Database::cfun(DatabaseConfig::cfun())->Select("authorization_tokens")->Where("token", true)->BindParam("token", $Token)->Run()->Get() ?? null;
            default:
                throw new \ErrorException("Invaid Token Type");
        }
    }

    public function DeleteToken($TokenType, $Token): bool
    {
        switch ($TokenType) {
            case "access":
                return Database::cfun(DatabaseConfig::cfun())->CustomSql("DELETE FROM access_tokens WHERE token=:token")->Where("token", true)->BindParam("token", $Token)->Run() ? true : false;
            case "refresh":
                return Database::cfun(DatabaseConfig::cfun())->CustomSql("DELETE FROM refresh_tokens WHERE token=:token")->Where("token", true)->BindParam("token", $Token)->Run() ? true : false;
            case "authorization":
                return Database::cfun(DatabaseConfig::cfun())->CustomSql("DELETE FROM authorization_tokens WHERE token=:token")->Where("token", true)->BindParam("token", $Token)->Run() ? true : false;
            default:
                throw new \ErrorException("Invaid Token Type");
        }
    }

    public function AddRefreshToken($AccountId, $ClientId): string|null
    {
        $Token = sha1(random_int(0, 9999999) . microtime() . microtime() . microtime() . microtime() . microtime() . microtime()) . sha1(microtime() . microtime() . microtime() . microtime() . microtime() . microtime());

        return Database::cfun(DatabaseConfig::cfun())->Insert("refresh_tokens", ["token", "account_id", "client_id"])
            ->BindParam("token", $Token)
            ->BindParam("account_id", $AccountId)
            ->BindParam("client_id", $ClientId)
            ->Run() ? true : false;
    }

    public function AddAccessToken($AccountId, $ClientId): string|null
    {
        $Token = sha1(random_int(0, 9999999) . microtime() . microtime() . microtime() . microtime() . microtime() . microtime()) . sha1(microtime() . microtime() . microtime() . microtime() . microtime() . microtime());

        return Database::cfun(DatabaseConfig::cfun())->Insert("access_tokens", ["token", "account_id", "client_id", "expire_at"])
            ->BindParam("token", $Token)
            ->BindParam("account_id", $AccountId)
            ->BindParam("client_id", $ClientId)
            ->BindParam("expire_at", date("Y-m-d H:i-s", (time() + (60 * 60)))) // Authorize token 60 dakika(1 saat) geçerli olacaktır
            ->Run() ? $Token : null;
    }

    public function AddAuthorizationToken($AccountId, $ClientId): string|null
    {
        $Token = sha1(random_int(0, 9999999) . microtime() . microtime() . microtime() . microtime() . microtime() . microtime()) . sha1(microtime() . microtime() . microtime() . microtime() . microtime() . microtime());

        return Database::cfun(DatabaseConfig::cfun())->Insert("authorization_tokens", ["token", "account_id", "client_id", "expire_at"])
            ->BindParam("token", $Token)
            ->BindParam("account_id", $AccountId)
            ->BindParam("client_id", $ClientId)
            ->BindParam("expire_at", date("Y-m-d H:i-s", (time() + (60 * 1)))) // Authorize token 1 dakika geçerli olacaktır
            ->Run() ? $Token : null;
    }

    /**
     * @return TokenModel
     */
    public static function cfun(): TokenModel
    {
        return new TokenModel();
    }
}