<?php
function lister_image($repertoire)
{
   $pointeur = opendir($repertoire); 
   $i = 0; 
   while ($fichier = readdir($pointeur)) {
   if (substr($fichier, -3) == "gif" || substr($fichier, -3) == "jpg" || substr($fichier, -3) == "png" ||substr($fichier, -4) == "jpeg" || substr($fichier, -3) == "PNG" || substr($fichier, -3) == "GIF" || substr($fichier, -3) == "JPG")
      {
	   $image[$i][name]= $repertoire.$fichier;
       $image[$i][caption]= $fichier;
       $i++;
      }       
   } 
   closedir($pointeur); 
   if(count($image)>0) //comptage du nbr d'el pour trier
   {
   array_multisort($image, SORT_ASC); 
   }
   
   return $image;
}

?>