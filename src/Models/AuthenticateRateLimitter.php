<?php

namespace Hasirciogli\ProAuth\Models;

use Hasirciogli\Hdb\Database;
use Hasirciogli\ProAuth\Config\DatabaseConfig;

class AuthenticateRateLimitter
{
    /**
     * @param string $IpAddress
     * @return bool
     */
    public function GetLastRequestTime($IpAddress): string
    {
        return ($Result = Database::cfun(DatabaseConfig::cfun())->Select("authenticate_requests")
            ->Where("ip_address", true)
            ->OrderBy("created_at", "DESC")
            ->BindParam("ip_address", $IpAddress)
            ->Run()->Get()) ? strtotime($Result["created_at"]) : null;
    }

    /**
     * @param string $IpAddress
     * @param string $Limit
     * @return array|null
     */
    public function GetLastRequests($IpAddress, $Limit): array|null
    {
        return ($Result = Database::cfun(DatabaseConfig::cfun())->Select("authenticate_requests")
            ->Where("ip_address", true)
            ->OrderBy("created_at", "DESC")
            ->Limit($Limit)
            ->BindParam("ip_address", $IpAddress)
            ->Run()->Get("all")) ? $Result : null;
    }



    /**
     * @param string $IpAddress
     * @return bool
     */
    public function AddToDatabase($IpAddress): bool
    {
        return (bool) Database::cfun(DatabaseConfig::cfun())->Insert("authenticate_requests", ["ip_address"])
            ->BindParam("ip_address", $IpAddress)
            ->Run();
    }

    /**
     * @param string $IpAddress
     * @param string $Minute
     * @return bool
     */
    public function AddBan($IpAddress, $Minute): bool
    {
        return (bool) Database::cfun(DatabaseConfig::cfun())->Insert("authenticate_requests_blocks", ["ip_address", "block_end"])
            ->BindParam("ip_address", $IpAddress)
            ->BindParam("block_end", date("Y-m-d H:i-s", (time() + (60 * $Minute)))) // Ban token $Minute dakika kadar geçerli olacaktır
            ->Run();
    }

    /**
     * @param string $IpAddress
     * @return bool
     */
    public function GetBan($IpAddress): bool
    {
        $LastBan = Database::cfun(DatabaseConfig::cfun())
            ->Select("authenticate_requests_blocks")
            ->Where("ip_address", true)
            ->BindParam("ip_address", $IpAddress)
            ->OrderBy("block_end", "DESC")
            ->Limit("10")
            ->Run()->Get("all");


        $IsBanned = false;

        if ($LastBan) {
            foreach ($LastBan as $Ban):
                if (!$IsBanned) {
                    $CurTime = time();
                    $BanTime = strtotime($Ban["block_end"]);
                    $DiffTime = $BanTime - $CurTime;

                    if ($DiffTime > 0) {
                        $IsBanned = true;
                        break;
                    }
                }
            endforeach;
        }

        return $IsBanned;
    }

    /**
     * @param string $IpAddress
     * @return bool
     */
    public function RunRateLimitter($IpAddress): bool
    {
        $this->AddToDatabase($IpAddress);

        $IpBan = $this->GetBan($IpAddress);

        if ($IpBan) {
            return true;
        }

        $Requests = $this->GetLastRequests($IpAddress, 10);

        $EndTime = 0;
        $Fence = 0;

        if ($Requests) {
            foreach ($Requests as $Req):
                $EndTime++;

                $LastTime = strtotime($Req["created_at"]);
                $CurTime = time();
                $DiffTime = $CurTime - $LastTime;

                if ($DiffTime < 3)
                    $Fence++;
            endforeach;
        }

        if ($Fence > 2) {
            $this->AddBan($IpAddress, 3 * $Fence);
            return true;
        }

        return false;
    }


    /**
     * @return AuthenticateRateLimitter
     */
    public static function cfun(): AuthenticateRateLimitter
    {
        return new AuthenticateRateLimitter();
    }
}