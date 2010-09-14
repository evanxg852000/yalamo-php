<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 *  MODEL IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */

/* Class Model Definition */
class Model {
protected $Database;
protected $Table;
protected $ResultSet;

public function  __construct() {
    $this->Database=Database::Instance();
}
public function   __destruct() {

}
public function   __toString() {
   return "Model base Class";
}

protected function Select($id="*"){

}
protected function Insert($object=array('')){

}
protected function Update($id){

}
protected function Delete($id="*"){

}


}



