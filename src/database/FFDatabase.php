<?php

namespace HProAuth\database;

use mysql_xdevapi\Exception;
use PDO;
class FFDatabase
{
    private $db_host = configs_db_host;
    private $db_name = configs_db_name;
    private $db_username = configs_db_username;
    private $db_password = configs_db_password;

    public PDO|null $connection = null;

    public function init()
    {
        try {
            $this->connection = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name . ";charset=utf8", $this->db_username, $this->db_password);
            return $this;
        } catch (Exception $e) {
            die("Veritabanı bağlantı hatası");
        }

    }

    public static function cfun()
    {
        return new FFDatabase();
    }
}