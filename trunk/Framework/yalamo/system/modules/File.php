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
 * @version		Version 1.0
 * @filesource          Path.php
 */


/*
 * FILE IMPLEMENTATION
 *
 * Contains the path manipulation/info functionalities
 */
class File {
    private $path;

    public function  __construct($path) {
        $this->path = new Path($path);  
    }
    public function  __toString() {return "Object of Type: File"; }

    public function Extension(){
        $this->path->Extension();
    }
    
    public function Create($content=""){
        $handle=fopen($this->path->Path(),'w');
	if(fwrite($handle,$content)){
            fclose($handle);
            $this->existance=true;
            return true;
	}
	else {
            fclose($handle);
            return false;
	}
    }
    public function Content(){
        if(file_exists($this->path->Path())){
           return file_get_contents($this->path->Path());
        }
        else{
            Inspector::AddError(Error::YE100, $path);
            return false;
        }
       
    }
    public function Append($content){
        if (file_exists($this->path->Path())){
            $handle=fopen($this->path->Path(),'a');
            fwrite($handle,$content);
            fclose($handle);
            return true;
	}
	else{
            Inspector::AddError(Error::YE100, $path);
            return false;
        }
    }
    
    public function Copy($dest, $overwrite=false){
        if((file_exists($dest)) && ($overwrite==false)){
            return false;
        }
        if (file_exists($this->path->Path())){
          return  @copy($this->path->Path(), $dest);
        }
        else {
            Inspector::AddError(Error::YE100, $path);
            return false;
        }
    }
    public function Delete(){
        if(file_exists($this->path->Path())){
            return  @unlink($this->path->Path());
        }
        else{
            Inspector::AddError(Error::YE100, $path);
            return false;
        }
    } 
    
    

    
    
    //TODO Uplaod and Downlaod
    public function Upload($files, $target){

    }
    public function Download($files,$target){

    }

   
}
