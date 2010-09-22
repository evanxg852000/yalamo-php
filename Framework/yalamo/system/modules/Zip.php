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
 * Zip IMPLEMENTATION
 *
 * Contains the directory manipulation/info functionalities
 */

//------------------------------------------------------------------------------
/**
 * Zip Class
 *
 * The class that contains the framework enumeration and static methods
 * to do useful thing.
 */
class Zip {
	#handle of the zip object
	Private $handleZip;
	# path origin folder
	Private $originePath;
	#File name to be extracted or it can be the name of the file to be zipped
	Private $fileName;
	#path destination folder
	Private $destinationPath;
	#list of file to be added to a zip file
	Private $fileList;

	#use the magic method to display a warnnig when this object is echoed
	Public Function __tostring()
	{
		return "Please, I have not anything to show";
	}

	#constructor which takes two parameters
	#1st parameter: $path is the path of the folder wich  content the file
	#2nd parameter: $filename is the file name it self
	Public Function __construct($path,$filename)
	{
		 $this->originePath = $path;
		 $this->fileName = $filename.'.zip';
		 $this->handleZip = new ZipArchive;
	}

	#this method create a zip file
	#return a boolean value to notify if it succeded or failled
	Public Function CreateZip()
	{
		#remember that in the constroctor we concateneted the zip extension to the $filename name given as a parameter
		#but now we want this file name  without any extention to be added as the name of the empty folder
		#to mitigate that we get rid of the file extension by using the substr function
		$emptyFolderName= substr($this->fileName, 0,strlen($this->fileName)-4);

		#Now we try to open the zip in creation mode
		$bool = $this->handleZip->open( $this->originePath.$this->fileName, ZipArchive::CREATE);
		if ($bool === TRUE)
		{
			#we add to the zip object  our files or usually folder (the case in this context)
			$this->handleZip->addEmptyDir($emptyFolderName);
			#we close the stream to clean the ressource
			$this->handleZip->close();
			#return the notification
			return true;
		}
		else
		{
			#return the notification
			return false;
		}

	}

    #this method extract the content of a zip file in a destination folder it takes one parameter
	#Parameter: $destination is the destination path of the final extracted files
	#return a boolean value to notify if it succed or failled
	Public Function ExtractFiles($destination)
	{
		#we set the internal menber of our zip object
		$this->destinationPath = $destination;
		#we try to open the zip file
		#note that the file path is obtained by concatenating its folder to its name
		$bool = $this->handleZip->open($this->originePath.$this->fileName);

		if ( $bool== TRUE)
		{
			#if we succeded to open the zip file then we extract its content in the destination folder
			$this->handleZip->extractTo($this->destinationPath);
			#we close the stream to cleanthe ressouce
			$this->handleZip->close();
			#return the notification
			return true;
		}
		else
		{
			#return the notification
			return false;
		}
	}

	#this method add some files to a zip file takes a list of files ass parameter
	#Parameter: $list=array('image.png','myfolder/somefile.css','photo.jpg')
	#return a boolean value to notify if it succed or failled
	Public Function AddFiles($filelist)
	{
		#set the internal file list of our object
		$this->fileList=$filelist;
		#To obtaine the directory of our ziped file we extract its extention and concatenate the dir separator
		$zippedfolder=substr($this->fileName, 0, strlen($this->fileName)-4).'/';
		#Now we try to open the zip
		$bool = $this->handleZip->open($this->originePath.$this->fileName);

		  if ( $bool== TRUE)
		  {
			  #we walk in the array to ..
			  for($i=0;$i<count($this->fileList);$i++)
			  {
				#get the current file name
				$filename=basename($this->fileList[$i]);
				#add it to the zip by concatenating the zip folder already obtained earlier to the filename
				$this->handleZip->addFile($this->fileList[$i],$zippedfolder.$filename );
			  }

			#we close the stream to cleanthe ressouce
			$this->handleZip->close();
			#return the notification
			return true;
		  }
		  else
		  {
			return false;
		  }
	}

	#This method use some of the previous method to zip a complete folder and its content
	#return a boolean value to notify if it succed or failled
	# Note that when you want to call this method the folder must exist otherwise it will fail
	Public Function ArchiveFolder()
	{
		#To obtaine the directory of our ziped file we extract its extention and concatenate the dir separator
		#the result has to be appende to the original path member
		$directory=$this->originePath.substr($this->fileName, 0, strlen($this->fileName)-4).'/';
		#we call the inetrnal method CreateZip()
		$this->CreateZip();
		#we get the list file that are in the folder
		#this method will be declare at the end since it is a helper method
		#it takes the $directory variable we obtained earlier as a parameter
		$this->ListeFolder($directory);
		#Now we call the internal method AddFiles by passing the content of the folder as a parameter
		#the previous methode set our class member we are using  ($this->fileList)
		$bool=$this->AddFiles($this->fileList);

		#NOTE: since all those method give back a notification you should nest some  test conditions
		#by check if each method succeeded on its mission, but to keep thing simpler i prefere to only checck the last one
		if ($bool)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	#This method delete the archive file
	#Return a boolean value to nofify its sucess or its fail
	Public Function DeleteArchive()
	{
		#we use the unlink fuction to delete the file
		#the file path is its folder concatenated to its name
	   $bool=unlink($this->originePath.$this->fileName);
		if ($bool)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	#this is the helper method that we mentionned earlier
	#it takes a directory path as parameter
	#get the list of this directory in an array and give it back
	#or return false if it failled
	Private Function ListeFolder($directoryPath)
	{
		#initialize the result list and the counter
		$result=array();
		$i=0;
		#we try to open the directory
		  if($handleDir=opendir( $directoryPath))
		  {
			while ($file = readdir($handleDir))
			{
				#we check if the current pointer value is not a directory
				if(!is_dir($file))
				{
					#add the entry to the result list
					$result[$i]=$directoryPath.$file;
					#increment the couter
					$i++;
				}
			}
			#we close the stream to cleanthe ressouce
			closedir($handleDir);
		  }
		  else
		  {
			#if we could not open the dir for any reason we return false.
			return false;
		  }
		  $this->fileList=$result;
		  return true;
	}
}

