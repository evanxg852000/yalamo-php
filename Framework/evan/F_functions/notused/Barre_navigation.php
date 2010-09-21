<?php
function barre_navigation ($nb_total,$nb_rec_par_page,$page_actuelle) 
{
$barre_lien='';	
$i=0; //variable du param incremente selon le nombre d'enregistrement par page
$j=1; //varialbe du lien incremente de 1 a 1
$barre .='&nbsp;<A href="'.$_SERVER['PHP_SELF'].'?param=0" class="barlien"> << </A>&nbsp;'; //premier lien pointant vers le debut
while ($i <= $nb_total):
       // cette condition verifie pour ne pas metre de lien sur la page active
		if($i==$page_actuelle){
			$barre .='&nbsp;['.$j.']&nbsp;';
			}
		else
		{
			 $barre .='&nbsp;<A href="'.$_SERVER['PHP_SELF'].'?param='.$i.'" class="barlien">['.$j.']</A>&nbsp;';
		}
		 $i=$i+$nb_rec_par_page;
		 $j++;
endwhile;
$k=$i-$nb_rec_par_page; //permet de calculer le param du lien pointant vers la derniere page en utilisant la valeur actuelle de $i
$barre .='&nbsp;<A href="'.$_SERVER['PHP_SELF'].'?param='.$k.'" class="barlien"> >> </A>&nbsp;';
return $barre;
}
?>