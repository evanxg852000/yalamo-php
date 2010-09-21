<?php
function Arrondir($nb,$nb_av) // cette fonction arrondi un nombre en specifiant le nombre de chifrre apres la virgule
{ 
	//exemple on multiplie le nobre par 100(xemple) on l'arrodi et on divise par 100
	return ceil($nb*pow(10,$nb_av))/pow(10,$nb_av);;
}

	
?>
