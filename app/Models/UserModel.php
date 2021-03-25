<?php


namespace App\Models;


use Application\Models\BaseModel;

class UserModel extends BaseModel
{

    protected $id = 'id';

    protected $table = 'users';

    static function Instance(){
        return new UserModel();
    }

}