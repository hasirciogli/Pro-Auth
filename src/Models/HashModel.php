<?php

namespace Hasirciogli\ProAuth\Models;

use Hasirciogli\ProAuth\Models\ClientModel;

class HashModel
{


    /**
     * @param string $ClientId
     * @param string $RequestedHash
     * @return bool
     */
    public function VerifyClientHash($ClientId, $RequestedHash): bool
    {
        if (!($Client = ClientModel::cfun()->GetClient($ClientId)))
            return false;

        if (!$Client["client_secret"])
            return false;

        $HashTr = $ClientId . $Client["client_secret"];
        return (bool) (base64_encode(pack("H*", sha1($HashTr))) == $RequestedHash);
    }


    /**
     * @param string $ClientId
     * @param string $RedirectUri
     * @param string $RequestedHash
     * @return bool
     */
    public function VerifyClientHashWithRedirectUrl($ClientId, $RedirectUri, $RequestedHash): bool
    {
        if (!($Client = ClientModel::cfun()->GetClient($ClientId)))
            return false;

        if (!$Client["client_secret"])
            return false;


        $HashTr = $ClientId . $RedirectUri . $Client["client_secret"];
        return (bool) (base64_encode(pack("H*", sha1($HashTr))) == $RequestedHash);
    }

    /**
     * @param string $ClientId
     * @param string $RedirectUri
     * @param string $RequestedHash
     * @return bool
     */
    public function GenerateHashForAuthenticate($ClientId, $ClientSecret, $RedirectUri): string
    {
        $HashTr = $ClientId . $RedirectUri . $ClientSecret;
        return base64_encode(pack("H*", sha1($HashTr)));
    }


    /**
     * @return HashModel
     */
    public static function cfun(): HashModel
    {
        return new HashModel();
    }
}