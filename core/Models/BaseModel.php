<?php


namespace Application\Models;


class BaseModel
{

    protected $id = 'id';

    protected $table ;



    public function deleteById($id){
        return DB::delete()
            ->from($this->table)
            ->where("id=?")
            ->executeWith([$id]);
    }

    public function deleteByParams(string $conditions,$params){
        return DB::delete()
            ->from($this->table)
            ->where($conditions)->executeWith($params);
    }

    public function updateById(int $id, array $rows){
        return DB::update($this->table)
            ->update($this->table)
            ->set($rows)
            ->where("id=?")
            ->executeWith([$id]);
    }

    public function updateByParams(string $conditions,$params){
        return DB::update($this->table)->where($conditions)->executeWith($params);
    }

    public function findById(int $id,array $rows){
        return DB::select($rows)->from($this->table)->where('id=?')->executeWith([$id]);
    }

    public function findByParams($rows,string $conditions,array $params = []){
        return DB::select($rows)
            ->from($this->table)
            ->where($conditions)->executeWith($params);
    }

    public function find($rows,array $params = []){
        return DB::select($rows)
            ->from($this->table);
    }


    public function insert(array $rows,array $params){
        return DB::insertInto($this->table)
            ->set($rows)
            ->executeWith($params);
    }

}