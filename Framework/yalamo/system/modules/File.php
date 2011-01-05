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
 * @filesource          File.php
 */


/*
 * FILE IMPLEMENTATION
 *
 * Contains the file manipulation/info functionalities
 */
class File extends Object {
    private $path;
    private $uploaded_files;
    private $upload_report;


    public function  __construct($path) {
        $this->path = new Path($path);   
    }

    public function Extension(){
        $this->path->Extension();
    }
    
    public function Create($content=""){
        $handle=fopen($this->path->FullPath(),'w');
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
        if(file_exists($this->path->FullPath())){
            $handle = fopen($this->path->FullPath(), "rb");
            $contents = fread($handle, filesize($this->path->FullPath()));
            fclose($handle);
           return $contents; 
        }
        $this->Collect(Error::YE207);
        return false;       
    }
    public function FileMime(){
        return $this->mime;
        return finfo_file(finfo_open(FILEINFO_MIME_TYPE),  $this->path);
    }

    public function Append($content){
        if (file_exists($this->path->FullPath())){
            $handle=fopen($this->path->FullPath(),'a');
            fwrite($handle,$content);
            fclose($handle);
            return true;
	}
        $this->Collect(Error::YE207);
        return false;
    }
    
    public function Copy($dest, $overwrite=false){
        if((file_exists($dest)) && ($overwrite==false)){
            return false;
        }
        if (file_exists($this->path->FullPath())){
          return  @copy($this->path->FullPath(), $dest);
        }
        $this->Collect(Error::YE207);
        return false;
    }
    public function Delete(){
        if(file_exists($this->path->FullPath())){
            return  @unlink($this->path->FullPath());
        }
        $this->Collect(Error::YE207);
        return false;
    } 
    
    private function maxupload(){
       $postmaxsize = trim(ini_get('post_max_size'));
       $unit = strtolower($postmaxsize{strlen($postmaxsize)-1});
       switch($unit) {
           case 'g':
               $postmaxsize *= 1024;
           case 'm':
               $postmaxsize *= 1024;
           case 'k':
               $postmaxsize *= 1024;
       }
       return $postmaxsize;
    }
    public function Upload($allowedmimetypes=array("image/gif","image/png","image/bmp","image/jpg","image/jpeg","text/pdf","text/txt" )){
        $assertion=true;
        $this->uploaded_files=array();
        $this->upload_report=array();
        if($this->path->IsDirectory()){ $targetfolder=$this->path->FullPath();}
        $maxupload=$this->maxupload();
        if(empty($_FILES)){  return false; }
        
        foreach ($_FILES as $file) {
             if(is_uploaded_file($file["tmp_name"])){
                $name     	= preg_replace('/[^a-z0-9.-]/', '-', strtolower(basename($file["name"])));
                $type 		= $file["type"];
		$tmp_name 	= $file["tmp_name"];
		$error   	= $file;
                if($file["error"]!=0){
                    $assertion=false;
                    $this->PCollect(Error::YE203,$file);
                    continue;
                }
                
		if($file["size"] <= $maxupload){  //check for the size
                    if(in_array($type, $allowedmimetypes)){ //check if file mimetype is allowed
                        if(move_uploaded_file($tmp_name, $targetfolder.$name)){ //move the file
                             $this->uploaded_files[]=$targetfolder.$name;    
                        }
                        else{
                            $assertion=false;
                            $this->PCollect(Error::YE203,$file);
                        }
                    }
                    else {
                        $assertion=false;
                        $this->PCollect(Error::YE205,$file);
                    }
		}
                else{
                   $assertion=false;
                   $this->PCollect(Error::YE204,$file);
                }    
             }
             else{
                 $assertion=false;
                 $this->PCollect(Error::YE203,$file);
             }
             clearstatcache();
        }
        return $assertion;
    }  
    public function UploadedFiles(){
        return $this->uploaded_files;
    }
    public function Download(){
        if(file_exists($this->path->FullPath())){
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.$this->path->FileName());
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($this->path->FullPath()));
            ob_clean();
            flush();
            readfile($this->path->FullPath());
            exit;
        }
        $this->Collect(Error::YE207);
        return false;
    }
  
}

