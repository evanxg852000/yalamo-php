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
 * @filesource          Mail.php
 */

/*
 * MAIL IMPLEMENTATION
 *
 * Define functionalities for sending mails
 */

//------------------------------------------------------------------------------
/**
 * Mail Class
 *
 * Implements the method to create and send a mail via pmp mail function
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
        $this->Collect(Error::YE401);
        return false ;

      }

}


