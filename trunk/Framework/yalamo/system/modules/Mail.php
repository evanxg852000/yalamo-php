<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mail
 *
 * @author Administrator
 */
final class Mail extends Object {
    private $emailexpeditor;
    private $nameexpeditor;
    private $emaildestination;
    private $subject;
    private $content;
    private $headers;
    private $type;

    public function __construct($nameexpeditor,$emailexpeditor,$emaildestination,$type) {
        $this->emailexpeditor=$emailexpeditor ;
        $this->nameexpeditor= $nameexpeditor;
        $this->emaildestination=$emaildestination ;
        $this->type=$type;
     }
    public function send($subject, $content){
        $this->subject=$subject;
        Switch($this->type){
            case 'text':
                $headers ="From: \"$this->nameexpeditor\" <$this->emailexpeditor> \n";
                $headers .="Reply-To: $this->emailexpeditor \n";
                $headers .='Content-Type: text/plain; charset="iso-8859-1"'."\n";
                $headers .='Content-Transfer-Encoding: 8bit';
                $this->headers=$headers;
                $this->content=$content;
            break;
            case 'html':
                $headers ="From: \"$this->nameexpeditor\" <$this->emailexpeditor> \n";
                $headers .="Reply-To: $this->emailexpeditor \n";
                $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
                $headers .='Content-Transfer-Encoding: 8bit';
                $this->headers=$headers;
                $this->content="<html><head><title>".$this->subject."</title></head><body>".$content."</body></html>";
            break;
        }
        if(mail($this->emaildestination, $this->subject, $this->content, $this->headers)){
            return true ;
        }
        $this->Collect(Error::YE100);
        return false ;

      }

}


