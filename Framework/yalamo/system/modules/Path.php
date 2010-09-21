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
 * PATH IMPLEMENTATION
 *
 * Contains the path manipulation/info functionalities
 */

//------------------------------------------------------------------------------
/**
 * Path Class
 *
 * The class that contains the framework enumeration and static methods
 * to do useful thing.
 */
final class Path {
    private $path;
    private $segments;
    private $info;
    
    public function  __construct($path) {
        $temparray=array(); 
        if(is_array($path)){
             $this->segments=$path; 
             $this->path=implode(Yalamo::Ds, $path);
         }
         else {
            $this->segments=explode(Yalamo::Ds, $path);
            //if($temparray[0]==Yalamo::Void){unset($temparray[0]);}
            //if($temparray[count($temparray)]==Yalamo::Void){unset($temparray[count($temparray)]);}
            foreach ($temparray as $val)
            {
                //[]=$val;
            }
            var_dump($this->segments);
            $this->path=implode(Yalamo::Ds, $this->segments);
        }
        $this->info=pathinfo($this->path);
    }
    public function  __toString() {return "Object of Type: Path"; }
    
    public function  Append($piece){
       if(is_array($piece)){
           foreach ($piece as $val){
               $this->segments[]=$val;
                $this->path .=Yalamo::Ds.$val;
           }
       }
       else{
            $this->segments[]=$piece;
            $this->path .=Yalamo::Ds.$piece;
        }
        $this->info=pathinfo($this->path);
    }

    public function Segment($num=null){
        if(is_null($num)){
            return $this->segments;
        }
        else {
            if(array_key_exists($num, $this->segments)){
               return $this->segments[$num];
            }
            return null;
        }
        
    }
    public function Path(){
        return $this->path;
    }
    public function PathInfo(){
        return $this->info;
    }
    public function Root(){
        return $this->segments[0];
    }
    public function Directory(){
       return dirname($this->path);
    }
    public function FileName(){
        return basename($this->path);
    }
    public function Extension(){
        if(array_key_exists("extension", $this->info)){
            return $this->info["extension"];
        }
        else{
            return false;
        }
    }

    public function IsFile(){
        if($this->Extension()){
            return true;
        }
        else{
            return false;
        }
    }   
    public function IsDirectory(){
        return !$this->IsFile();
    }
   
}

