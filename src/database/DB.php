<?php

namespace HProAuth\database;

use mysql_xdevapi\Exception;
use PDO;
class DB
{
    private $db_host = configs_db_host;
    private $db_name = configs_db_name;
    private $db_username = configs_db_username;
    private $db_password = configs_db_password;

    private PDO|null $connection = null;

    private false|\PDOStatement $tV = false;
    private bool $tV2 = false;
    private string $tempSql = "";
    private array $tempBParams = [];

    private function checkDB()
    {
        if($this->connection)
            return $this;

        try {
            $this->connection = new PDO("mysql:host=" . $this->db_host . ";charset=utf8;dbname=". $this->db_name, $this->db_username, $this->db_password);
            return $this;
        } catch (\Exception $e) {
            die("Veritabanı bağlantı hatası" . $e->getMessage());
        }

    }

    private function closeConnection(): void
    {
        if(!$this->connection)
            return;

        $this->connection = null;
    }




    public function use(string $dbName): DB{
        if(!$this->connection)
            $this->checkDB();

        $this->tempSql = "USE ". $dbName.";";

        return $this;
    }

    public function lastInsertId(): int {
        if(!$this->connection)
            $this->checkDB();

        return $this->connection->lastInsertId() ?? -1;
    }

    public function select(string $tableName): DB {

        $this->tempSql = "SELECT * FROM " . $tableName;

        return $this;
    }

    public function insert(string $tableName, $dataset): DB {

        $tf = "";
        $tt = "";

        foreach ($dataset as $item) {
            if(strlen($tf) <=0)
                $tf .= "$item";
            else
                $tf .= ", $item";

            if(strlen($tt) <=0)
                $tt .= ":$item";
            else
                $tt .= ", :$item";

        }

        $this->tempSql = "INSERT INTO $tableName($tf) VALUES ($tt)";

        return $this;
    }

    public function bindParam(string $key, string $value): DB{

        $this->tempBParams[$key] = $value;


        return $this;
    }

    public function where(string $key, bool $binaryMode = false): DB{

        if(str_contains($this->tempSql, "WHERE"))
            $this->tempSql .= " AND" . ($binaryMode ? " BINARY" : "") ." $key=:$key";
        else
            $this->tempSql .= " WHERE". ($binaryMode ? " BINARY" : "") ." $key=:$key";

        return $this;
    }

    public function whereOr(string $key, bool $binaryMode = false): DB{

        if(str_contains($this->tempSql, "WHERE"))
            $this->tempSql .= " OR" . ($binaryMode ? " BINARY" : "") ." $key=:$key";
        else
            $this->tempSql .= " WHERE". ($binaryMode ? " BINARY" : "") ." $key=:$key";

        return $this;
    }

    public function limit($start, $limit = -1): DB {
        $this->tempSql .= ' LIMIT ' . $start . ($limit != -1 ? ", $limit" : "");

        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $sql = $this->tempSql .= ' ORDER BY ' . $column . ' ' . $direction;

        return $this;
    }

    public function customSql($sql): DB
    {
        $this->tempSql = $sql;

        return $this;
    }

    public function run(): false | DB {
        $fdb = $this->checkDB();

        $this->tV  = $fdb->connection->prepare($this->tempSql);
        $this->tV2 = $this->tV->execute($this->tempBParams);

        return $this->tV2 ? $this : false;
    }


    public function get(string $type = ""): mixed
    {
        if($this->tV2)
        {
            if ($type == "all")
                return $this->tV->fetchAll(PDO::FETCH_ASSOC);
            else
                return $this->tV->fetch(PDO::FETCH_ASSOC);
        }
        else return false;
    }



    public static function cfun()
    {
        $x = new DB();
        return $x->checkDB();
    }
}
