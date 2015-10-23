<?php
#error_reporting(0);
ini_set('max_execution_time', 1200);
date_default_timezone_set("Asia/Bangkok");
$conn = mysqli_connect('localhost','root','MyNewPass','billing');


/* start list function */
function getFileExtension($fileName){
   $parts = explode(".",$fileName);
   return $parts[count($parts)-1];
}

function strposa($haystack, $needle, $offset=0) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $query) {
        if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
    }
    return false;
}
/* end list function */

/* start get attachment email */
$root_   	   = $_SERVER['DOCUMENT_ROOT']."/schd_bill/Billing_Files/";
#die($root_);
if (!file_exists($root_.date("Ym"))) {
    mkdir($root_.date("Ym"), 0777, true);
}

$root_dir	   = $root_.date("Ym")."/";
$server        = '{mail.edi-indonesia.co.id:110/pop3/notls}INBOX';
$username      = 'ibnu.ridho';
$password      = 'M!3_t3gt3g';
$count = 0;
$imap          = imap_open($server, $username, $password) or die("imap connection error");

$emails        = imap_search($imap, 'FROM "adminepc@edi-indonesia.co.id" SINCE "20-Oct-2015"', SE_UID);
// $emails        = imap_search($imap, 'SINCE "22-Oct-2015"', SE_UID);   

if($emails){
    foreach($emails as $m){

        $header = imap_header($imap, $m);
        $message = imap_fetchbody($imap,$m, 1);

        $email[$m]['from']        = $header->from[0]->mailbox.'@'.$header->from[0]->host;
        // $email[$m]['fromaddress'] = $header->from[0]->personal;
    	$email[$m]['fromhost']    = $header->from[0]->host;
        $email[$m]['to']          = $header->to[0]->mailbox;
        $email[$m]['subject']     = $header->subject;
        $email[$m]['message_id']  = $header->message_id;
        $email[$m]['date']        = $header->udate;
        

        // $from       = $email[$m]['fromaddress'];
    	$from_host  = $email[$m]['fromhost'];
        $from_email = $email[$m]['from'];
        $to         = $email[$m]['to'];
        $subject    = $email[$m]['subject'];
    	$message_id = $email[$m]['message_id'];
    	$date_mail  = $email[$m]['date'];			

        echo $message_id . '</br>';     
        echo $from_host . '</br>';  
        echo $from_email . '</br>';
        echo $to . '</br>';
        echo $subject . '</br>';           
        echo $message . '</br>';             
        echo date("Ymd_His",$date_mail) . '</br></br>';
        echo $date_mail . '</br></br>';

        $structure  = imap_fetchstructure($imap, $m);
        
        $attachments = array();        
    }
}

imap_close($imap);
/* end get attachment email */
sleep(5);

?>
