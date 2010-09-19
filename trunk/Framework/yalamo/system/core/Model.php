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
    protected $Query;
    protected $Table;

    public function  __construct() {
        $this->Query=new Query();
        $this->Table=get_class($this);
    }
    public function  __destruct(){
        unset($this->Query);
    }
    public function  __toString() {return "Model base Class"; }

    protected function Table($table=null){
        if(is_null($table)){ return $this->Table; }
        if(is_object($table)){
            $this->Table=get_class($table);
        }
        else{
            $this->Table=$table;
        }
    }
    protected function ResultSet(){
        return $this->Query->ResultSet();
    }
    protected function ResultObject(){
        return $this->Query->ResultObject();
    }
    protected function ResultArray(){
        return $this->Query->ResultArray();
    }

    protected function Select($condition=Yalamo::Void){
        $this->Query->Select($this->Table,Yalamo::All,$condition);
        return $this->Query->ResultObject();
    }
    protected function Insert($item){
        $keys=array_keys($item);
        $values=array_values($item);
        $this->Query->Insert($this->Table, $keys, $values);
        return $this->Query->AffectedRows();
    }
    protected function Update($values, $condition=Yalamo::Void){
        $this->Query->Update($this->Table, $values, $condition);
        return $this->Query->AffectedRows();
    }
    protected function Delete($condition=Yalamo::Void){
        $this->Query->Delete($this->Table, $condition);
        return $this->Query->AffectedRows();
    }
    
}

/* Base Class Table  */
abstract  class Table{
    public final function Drop(){
      $sql="DROP TABLE ".get_class($this)." ;";
      $db=Database::Instance()->Handle()->Execute($sql);
    }
    public final function Fields(){
       $reflection=new ReflectionClass($this);
       $properties=$reflection->getProperties();
       $result=array();
        foreach ($properties as $property) {
            $result[]=$property->getName();
        }
        return $result;
    }
    public function Rows(){
        return new TableRow(get_class($this));
    }
}

/* Row Class*/
final class TableRow{
    private $table;
    public function  __construct($table) {
        $this->table=new $table;
    }
    public function Create($object){
        if(is_object($object)){
            if($object->Fields()==$this->table->Fields()){
               $reflection=new ReflectionClass($object);
               $properties=$reflection->getProperties();
               $result=array();
                foreach ($properties as $property) {
                    $result[$property->getName()]=$property->getValue($object);
                }
                return $result;
            }
        }
        $Inspector =Inspector::Instance();
        $Inspector->Add(Error::YE101,$object);
    }
}
