<?php 

namespace App\database;
use App\assignments\databaseservice\DatabaseServiceInterface;


class MysqlDatabaseService implements DatabaseServiceInterface
{
    public function GetClientDetailsBy_ClientId($ClientId) : null | array { return null; }
    public function GetAccountDetailBy_EmailPassword($Email, $Password) : null | array { return null; }
    public function GetAccountDetailBy_AccountId($AccountId) : null | array { return null; }
    public function GetAccountDetailBy_Token($Token) : null | array { return null; }

    public static function cfun() : MysqlDatabaseService {
        return new MysqlDatabaseService();
    }
}


?>