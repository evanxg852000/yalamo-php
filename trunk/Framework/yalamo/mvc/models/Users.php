<?php
class Users extends Model {
    public function  __construct() {
        parent::__construct();
        $this->Component("Keylinker");
    }

    public function InsertUser($name){
        $u=new User();
        $u->id=null;
        $u->name=$name;
        $item=$u->Rows()->Create($u);
        return parent::Insert($item);
    }
    public function SelectAll(){
       return parent::Select(Yalamo::All);
    }
    public function Escape(){
        $vars="evance'soumaor \nis fiek ";
        echo  $this->Query->Escape($vars);
        echo $this->Query->Prepare("SELECT* FROM Table Where Name={name} AND Age={age} ", array("name"=>"evan'ce","age"=>56));
        

    }

    public function  Delete($condition) {
        parent::Delete($condition);
    }

}

class User extends Table{
    public $id;
    public $name;
}