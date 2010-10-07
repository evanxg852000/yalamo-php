<?php if ( ! defined('YPATH')) exit('Access Denied !');
/**
 * Yalamo framework
 *
 * A fast,light, and constraint-free Php framework.
 *
 * @package		Yalamo
 * @author		Evance Soumaoro
 * @copyright           Copyright (c) 2009 - 2011, Evansofts.
 * @license		http://projects.evansofts.com/yalamof/license.html
 * @link		http://evansofts.com
 * @version		Version 0.1
 * @filesource          Form.php
 */

/*
 * FORM IMPLEMENTATION
 *
 * The class that implements user input validation using regular expression
 */

//------------------------------------------------------------------------------
/**
 * Validator Class
 *
 * Implements abstract methods from the DBDriver class for Sqlite engine
 */

final class Form extends Object {
    const  Get    = "GET";
    const  Post   = "POST";

    private $code;
    private $controls;

    public function  __construct($name, $action, $mixedata=false ,$method=Form::Post) {
        if($mixedata){
            $option="enctype=\"multipart/form-data\"";
        }
        else {
            $option=Yalamo::Void;
        }
        $this->code="<form name=\"$name\" action=\"$action\" method=\"$mathod\"  $option  >";
        $this->controls=array();
    }
    public function  __toString() {return "Object of Type: Form"; }

    public function Add($control){
        if(is_callable(array($control,"Code"))){
            $this->controls[$control->Name()]=$control;
            return $control;
        }

    }
    public function Remove($name){
        if(array_key_exists($name, $this->controls)){
            //$this->controls
            unset($this->controls[$name]);
        }

    }
    public function Close($dump=true){
        foreach ($this->controls as $control){
            $this->code .=$control->Code();
        }
        $this->code .="</form>";
        if($dump){
            echo $this->code;
        }
        return $this->code;
    }

}



abstract class Control {
    protected $label;
    protected $name;
    protected $stroption;

    protected $visible;
    Protected $enable;
 
    public function __construct($label, $name,$option) {
        $this->label=$label;
        $this->name=$name;
        $this->stroption=$this->formatoptions($option);
        $this->visible=true;
        $this->enable=true;
    }
    public function __toString(){return "Object of Type: Control"; }
    private function formatoptions($options){
        $stroption="";
        if(!is_array($options)){
           return;
        }
        foreach ($options as $name=>$value){
            if(is_numeric($name)){continue;}
            $stroption .=" $name=\"$value\" ";
        }
        return $stroption;
    }

    public function Name(){
        return $this->name;
    }
    public function Visible($value){
        if(is_bool($value)){
            $this->visible=$value;
        }
    }
    public function Enable($value){
        if(is_bool($value)){
            $this->visible=$value;
        }

    }

    
    public abstract function Code(){ }

    
}

/*=====================================================*/

class TextBox extends Control {
    //define additional properties
    private  $multiline;

    public function  __construct($label, $name, $option) {
        parent::__construct($label, $name,$option);
        $this->multiline=false;
    }  
    public function __toString(){return "Object of Type: TextBox"; }

    public function Multiline($value){
        
    }


    public function  Code() {
       return "var" ;
    }
}


$t=new TextBox("","","");
$t->Multiline=true;




/*

    public function TextBox($name,$label, $multine=false,$options=null){

    }
    public function ComboBox($name,$label, $entries,$options=null){

    }
    public function CheckBox($name,$entries,$options=null){

    }
    public function Button($name,$options=null){

    }
    public function Submit($name,$options=null){

    }
    public function Resset($name,$options=null){

    }

   */