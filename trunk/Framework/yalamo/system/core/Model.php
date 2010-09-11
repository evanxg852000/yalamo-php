<?php
/* Class Model Definition */
class Model {
protected $Database;
protected $Table;
protected $Resultset;

public function  __construct() {

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
