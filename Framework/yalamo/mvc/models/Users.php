<?php
class Users extends Model {
    public function  __construct() {
        parent::__construct();
    }

    public function InsertUser($name){
        $u=new User();
        $u->id=null;
        $u->name=$name;

        $item=$u->Rows()->Create($u);
        parent::Insert($item);
    }
    public function SelectAll(){
        parent::Select();
    }
}

class User extends Table{
    public $id;
    public $name;
}