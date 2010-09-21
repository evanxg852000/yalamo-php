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
 * @filesource          Directory.php
 */

/*
 * DIRECTORY IMPLEMENTATION
 *
 * Contains the directory manipulation/info functionalities
 */

//------------------------------------------------------------------------------
/**
 * Directory Class
 *
 * The class that contains the framework enumeration and static methods
 * to do useful thing.
 */

final class Dir {

    private $path;
    private $position;

    public function  __construct($path) {
        $this->path=new Path($path);
        if($this->path->IsFile()){
            $this->path=new Path($this->path->Directory());
        }
        $this->position=0;
    }
    public function   __toString() {return "Object of Type: Directory"; }

    public function  Create(){
        if (mkdir($this->repertoire, 0750)){
		return true;
	}
	else{
		return false;
	}
    }

    public function  Delete(){

    }

    public function  Entries($sort=true){
        $entrylist=array();
	$handle = opendir($this->path->Directory());
	while ($file = readdir($handle)) {
             if (substr($file, -1)!="." ) {
		$entrylist[]= $file;
             }
        }
        if((count($entrylist)>0) && ($sort==true)) {
            array_multisort($tableau, SORT_ASC);
        }
           closedir($handle);
           return $entrylist;
    }

    public function Back($step=1){

    }

    public function Forward($step=1){

    }



}

