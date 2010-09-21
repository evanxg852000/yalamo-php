<?php
//cette fonction nettoie tous ce qui passe par saisi pour eviter les injection xss
function clean($chaine)
{
	return htmlentities(trim($chaine));
}
?>