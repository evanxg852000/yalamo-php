<?php
function calender()
{
$mois=date('M');
$annee=date('Y');
//retourne le numero du denier jour du mois precedent
$num_dernier_jour_mois_prec=date("d",mktime(date("H")  ,date("i") ,date("s"),date("n"),0,date("Y"),-1));

//retourne le numero de la semaine du jour precedement calcule
$num_jour_semaine=date("w",mktime(date("H")  ,date("i") ,date("s"),date("n"),0,date("Y"),-1));

//on calcul le numero du dernier dimanche du mois precedent 
$num_der_dimanche=$num_dernier_jour_mois_prec-$num_jour_semaine; 

echo'<div id="calendar">';
echo '<div class="container">';
echo '<div id="tempLoader"></div>';
echo '<div id="mainLoader">';
echo '<label>'.$mois.' , '.$annee.'</label>';
echo '<table class="month" cellpadding="0">';
echo'<tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr>';
$depart=$num_der_dimanche;
for($i=0;$i<6;$i++)
{
	echo '<tr>';
	for($j=0;$j<7;$j++)
	{
		if(date('M')!=date("M",mktime(date("H")  ,date("i") ,date("s"),date("n")-1,$depart,date("Y"),-1))) //verifie si on nest le eme mois
		{
			echo '<td class="outsideDay">'.date("d",mktime(date("H")  ,date("i") ,date("s"),date("n")-1,$depart,date("Y"),-1)).'</td>';
		}
		else
		{
			if(date('d')==date("d",mktime(date("H")  ,date("i") ,date("s"),date("n")-1,$depart,date("Y"),-1))) //verifie si on nest le meme jour
			{
				echo '<td class="today">'.date("d",mktime(date("H")  ,date("i") ,date("s"),date("n")-1,$depart,date("Y"),-1)).'</td>';
			}
			else
			{
				echo '<td>'.date("d",mktime(date("H")  ,date("i") ,date("s"),date("n")-1,$depart,date("Y"),-1)).'</td>';
			}
		}
		$depart++;
	}
	echo '</tr>';
}
echo'</table></div></div></div>';
}

function afficheday()
{
echo date("D, M d Y");
}	
?>