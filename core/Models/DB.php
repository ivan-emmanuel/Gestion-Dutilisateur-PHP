<?php


namespace Application\Models;

use PDO;

class DB
{

    private $pdo;
    private static $instance = null;

    public function __construct()
    {
        extract(app_config("DB_MYSQL"));
        $this->pdo = new PDO("mysql:host=$HOST;dbname=$DBNAME;charset=utf8", $LOGIN, $PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function query(string $query,?array $params = null )
    {
        if ( !empty($params) ) {
            $req = $this->pdo->prepare($query);
            $req->execute($params);
        }else {
            $req = $this->pdo->query($query);
        }
        return  $req;
    }

    public function queryWithType(string $query,array $params )
    {
        $req = $this->pdo->prepare($query);
        foreach ($params as $param) {
            $req->bindValue($param[0], $param[1], $param[2]);
        }
        $req->execute();
        return  $req;
    }

    public static function Instance(){
        if (is_null(self::$instance)){
            self::$instance = new DB();
        }
        return self::$instance;
    }

    static function insertInto(...$params) : QueryBuilder {
        return QueryBuilder::Instance()->insert($params);
    }
    static function update($param) : QueryBuilder {
        return QueryBuilder::Instance()->update($param);
    }
    static function delete() : QueryBuilder  {
        return QueryBuilder::Instance()->delete();
    }
    static function deleteFrom(string $params) : QueryBuilder  {
        return QueryBuilder::Instance()->delete()->from($params);
    }
    static function select(...$fields) : QueryBuilder {
        return QueryBuilder::Instance()->select($fields);
    }
    static function latInsertId() {
        return self::Instance()->pdo->lastInsertId();
    }

}