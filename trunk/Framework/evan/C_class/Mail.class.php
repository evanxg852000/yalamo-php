<?php
class Mail
{
private $email_exp;
private $name_exp;
private $email_dest;
private $objet;
private $contenu;
private $headers;
private $type;

function __construct($name_exp,$email_exp,$email_dest,$type)
   {
	$this->email_exp=$email_exp ;
	$this->name_exp= $name_exp;
	$this->email_dest=$email_dest ;
	$this->type=$type;
   }
	
function send($objet, $contenu)
  {
	$this->objet=$objet;
	Switch($this->type)
	{
		case 'text':
			$headers ="From: \"$this->name_exp\" <$this->email_exp> \n";
			$headers .="Reply-To: $this->email_exp \n";
			$headers .='Content-Type: text/plain; charset="iso-8859-1"'."\n";
			$headers .='Content-Transfer-Encoding: 8bit';
			$this->headers=$headers;
			$this->contenu=$contenu;
			break;
		case 'html':
			$headers ="From: \"$this->name_exp\" <$this->email_exp> \n";
			$headers .="Reply-To: $this->email_exp \n";
			$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
			$headers .='Content-Transfer-Encoding: 8bit';
			$this->headers=$headers;
			$this->contenu="<html><head><title>".$this->objet."</title></head><body>".$contenu."</body></html>";
			break;
	}
	if(mail($this->email_dest, $this->objet, $this->contenu, $this->headers))
	{
	 return true ;
	}
	else
	{
	return false ;
	} 

  }
	
}
/*exemple d'utilisttion 
$mon_mail=new Mail('Evance','evance@yahoo.fr','brico@yaoo.fr','text');
$mon_mail->send('bingo!','salut mon pote');
*/
?>