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

final class Form {
    const  Get    = "GET";
    const  Post   = "POST";

    private $code;

    public function  __construct($name, $action, $mixedata=false ,$method=Form::Post) {
        if($mixedata){
            $option="enctype=\"multipart/form-data\"";
        }
        else {
            $option=Yalamo::Void;
        }
        $this->code="<form name=\"$name\" action=\"$action\" method=\"$mathod\"  $option  >";
    }
    public function  __toString() {return "Object of Type: Form"; }


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

    public function Close($dump=true){
        $this->code .="</form>";
        if($dump){
            echo $this->code;
        }
        return $this->code;
    }

    private function options($options){
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


}

