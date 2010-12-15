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
 * @filesource          Paypal.php
 */

/*
 * MONEYBOOKER EXTENSION
 *
 * Moneybooker extension for making simple checkout
 *
 */


class MoneyBooker {
    public static $CONFIG=array (
        "is_sandbox"=>false,
        "receiver_email"=>"evance123@yahoo.fr",
        "currency"=>"USD",
        "language"=>"EN",
        "button"=>"https://www.paypal.com/en_US/i/btn/x-click-but23.gif",
        "validate_url"=>"http://localhost/Framework/showconfirm",
        "cancel_url"=>"http://localhost/Framework/",
        "notification_url"=>"http://localhost/Framework/paypalipn"
    );

    private $configuration;
    private $html;

    public function __construct($config=null){
        $this->configuration=& $config ;
        if(is_null($config)){
            $this->configuration=& Paypal::$CONFIG;
        }
        if($this->configuration["is_sandbox"]){
            $this->html='<form id="paypal-form" action="https://www.sandbox.paypal.com/cgi-bin/webscr"  method="post">';
        }
        else {
            $this->html='<form id="paypal-form" action="https://www.paypal.com/cgi-bin/webscr" method="post">';
        }
    }

    public function Initiate($transactionname,$itemname,$quantity, $amount){
        $this->html .='
                <input type="hidden" name="cmd" value="_xclick"/>
                <input type="hidden" name="rm" value="2"/>
                <input type="hidden" name="no_shipping" value="1"/>
                <input type="hidden" name="no_note" value="1"/>
                <input type="hidden" name="currency_code" value="'.$this->configuration["currency"].'"/>
                <input type="hidden" name="lc" value="'.$this->configuration["language"].'"/>
                <input type="hidden" name="business" value="'.$this->configuration["receiver_email"].'"/>
                <input type="hidden" name="item_name" value="'.$transactionname.'"/>
                <input type="hidden" name="quantity" value="'.$quantity.'"/>
                <input type="hidden" name="item_number" value="'.$itemname.'"/>
                <input type="hidden" name="amount" value="'.number_format($amount,2).'"/>
                <input type="hidden" name="bn" value="PP-BuyNowBF"/>
                <input type="image" src="'.$this->configuration["button"].'" border="0"
                name="submit" alt="Make payments with PayPal - it\'s fast, free and secure!"/>
                <input type="hidden" name="return" value="'.$this->configuration["validate_url"].'"/>
                <input type="hidden" name="cancel_return" value="'.$this->configuration["cancel_url"].'"/>
                <input type="hidden" name="notify_url" value="'.$this->configuration["notification_url"].'" />
                </form>';
        return $this->html;
    }
    public function AddCustom($value){
        $this->html .='<input type="hidden" name="custom" value="'.$value.'">';
    }
    public function Verify($handler){
        $class=new ReflectionClass(get_class($handler));
        if(!$class->implementsInterface("IPayapalNotifyable")){
            return false;
        }
        $required = 'cmd=_notify-validate';
        // go through each of the POSTed vars and add them to the variable
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $required .= "&$key=$value";
        }
        // post back to PayPal system to validate
        $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($required) . "\r\n\r\n";
        if($this->configuration["is_sandbox"]){
            $fp = fsockopen ('www.sandbox.paypal.com', 443, $errno, $errstr, 30);
        }
        else {
            $fp = fsockopen ('www.paypal.com', 443, $errno, $errstr, 30);
        }

        if (!$fp) {
                // HTTP ERROR Failed to connect
              $handler->OnError("HTTPERROR",null);
        }
        else{
            fputs ($fp, $header.$required);
            while (!feof($fp)) {
                $result = fgets ($fp, 1024);
                if (strcmp ($result, "VERIFIED") == 0) {
                    $currency = $_POST["mc_currency"];
                    $status = $_POST["payment_status"];
                    $transaction_id = $_POST["txn_id"];
                    $receiver_email = $_POST["receiver_email"];

                    $data["name"]= $_POST["item_name"];
                    $data["quantity"]=$_POST["quantity"];
                    $data["id"]=$_POST['item_number'];
                    $data["custom"]=$_POST["custom"];
                    $data["payer_email"]=$_POST["payer_email"];
                    $data["amout"] = $_POST["mc_gross"];
                    if (  ($status == 'Completed') &&($receiver_email == $this->configuration["receiver_email"]) &&
                          ( $currency == $this->configuration["currency"]) &&   (!txn_id_used_before($txn_id))) {
                            $handler->OnComplet("COMPLITED",$data);
                    }
                     else{
                            $handler->OnFailiure(strtoupper($status),$data);
                     }
               }
               else if (strcmp ($result, "INVALID") == 0) {
                    $handler->OnInvalid("INVALID",$data);
                }
            }
            fclose ($fp);
        }
    }

}

interface IMoneybookerNotifyable {

    /*
     * Called when the transaction is completed
     *
     * Specific checks should be done in this handler
     * check the amount payed
     * check the transaction id
     * @param $data will contain transaction information
     */
    public function OnComplet($status,$data);

    /*
     * Called when the transaction is verified but not Completed
     */
    public function OnFailiure($status,$data);

    /*
     * Called when the transaction is invalid
     */
    public function OnInvalid($status,$data);

    /*
     * Called when there is a http erroe (the validation request is not back )
     */
    public function OnError($status,$data);
}

