<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataSet
 *
 * @author Administrator
 */
class Dataset extends Object{
    private $registry;

    private function  __construct() {
        $this->registry=array();
    }
    public function __toString() {return "Object of Type: Dataset";}
    public function  __set($name, $value) {
        if(is_array($value)){
          $this->registry[$name]=$value;  
        } 
    }
    public function  __get($name) {
        if(array_key_exists($name, $this->registry)){
            return $this->resgistry[$name];
        }
            return false;
    }



    public function FromDatabase($tables){

    }
    public function FromXml($argument){

    }
    public function FromJson($argument){

    }
    public function FromCvs($argument){

    }

    public function WriteDatabase() {

    }
    public function WriteXml($file){

    }
    public function WriteJson($file){

    }
    public function WriteCvs($file){

    }
  


}
?>
