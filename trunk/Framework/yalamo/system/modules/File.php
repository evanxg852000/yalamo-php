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
    private $fileInfo;

    public function  __construct($path) {
        $this->path=$path;

    }
    public function   __toString() {return "Object of Type: File"; }


}
