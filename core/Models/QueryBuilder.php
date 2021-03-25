<?php


namespace Application\Models;


class QueryBuilder
{

    private  $fields = [];
    private  $set = [];
    private  $conditions = [];
    private  $tables = [];
    private  $limit = null;
    private  $delete = false;
    private  $insert = null;
    private  $update = null;

    private  $pdo_query ;

    public static function Instance(){
        return new self;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function delete(){
        $this->delete = true;
        return $this;
    }

    public function update($table){
        $this->update = $table;
        return $this;
    }

    public function insert( ...$inserts){
        if( is_array($inserts[0]) ){
            $this->insert = $inserts[0];
        }else{
            $this->insert = $inserts;
        }
        return $this;
    }

    public function select( ...$fields){
        if( is_array($fields[0]) ){
            $this->fields = $fields[0];
        }else{
            $this->fields = $fields;
        }
        return $this;
    }

    public function set( ...$set){
        if( is_array($set[0]) ){
            $this->set = array_merge($this->set,$set[0]);
        }else{
            $this->set = array_merge($this->set,$set);
        }
        return $this;
    }

    /**
     * @param mixed array|string ...$conditions
     * @return $this
     */
    public function where(...$conditions){
        if( is_array($conditions[0]) ){
            $this->conditions = array_merge($this->conditions,$conditions[0]);
        }else{
            $this->conditions = array_merge($this->conditions,$conditions);
        }
        return $this;
    }

    public function from( $table,?string $alias =null) {
        if (is_null($alias)){
            $this->tables[] = $table;
        }else{
            $this->tables[] = "$table AS $alias";
        }
        return $this;
    }


    public function __toString(){
        $conditions = "";
        $limit = "";
        if ( !empty($this->limit) ){
            $limit = " LIMIT 0, {$this->limit}";
        }
        if ( !empty($this->conditions) ){
            $conditions = " WHERE ".implode(' AND ',$this->conditions);
        }
        if( !empty($this->insert) ){
            return 'INSERT INTO '. implode(' , ',$this->insert)  ." SET ".implode(' , ',$this->set) ;
        }
        if (  !empty($this->update) ) {
            return 'UPDATE '.$this->update ." SET ".implode(' , ',$this->set)  .$conditions;
        }
        if ( $this->delete !== false ) {
            return 'DELETE FROM '. implode(' ,',$this->tables) .$conditions;
        }

        if ( !empty($this->fields) ) {
            return 'SELECT '.implode(' ,',$this->fields)  . " FROM ".implode(' ,',$this->tables)  .$conditions.$limit;
        }
    }

    public function executeWith(array $params = []){
         $query = (string) $this;
         return DB::Instance()->query($query,$params);
    }

    public function executeWithType(array  $params){
        return DB::Instance()->queryWithType($this->__toString(),$params);
    }

    public function  prepare(){
        $query = (string) $this;
        return DB::Instance()->getPdo()->prepare($query);
    }

    public function execute() {
        $this->pdo_query->execute();
        return $this->pdo_query;
    }

    public function with($index,$value,$type = \PDO::PARAM_STR){
        if( !empty($this->pdo_query) ){
            $this->pdo_query->bindValue($index,$value,$type);
            return $this;
        }
        $pdo = DB::Instance()->getPdo();
        $this->pdo_query = $pdo->prepare($this->__toString());
        $this->pdo_query->bindValue($index,$value,$type);
        return $this;
    }

    public function pdoQuery(){
        $qr = $this->__toString();
        return DB::Instance()->query($qr);
    }


}