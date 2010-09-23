<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * XML IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */
class Xml {
    private $file;
    private $xmldocument;

    public function  __construct($file) {
        if(!file_exists($file)){
            Yalamo::$Errors="Xml file not found : value= $file ";
        }
        $this->file=$file;
        //http://php.net/manual/en/book.simplexml.php
        $this->xmldocument=simplexml_load_file($file);


    }


}

