<?php

// format email headers
$to = '';

//email configuration
$from = "accounts@a-gtm.com";


$subject = 'Email Confirmation';

$headers = 'From: "AGTM Accounts" <' . $from . '>' . '\r\n';
$headers .= "Reply-To: ". $from . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

// the message

// send email
// if(mail("tncedric@yahoo.com",$subject ,$msg, $headers))
// {
//     echo 'Gmail Sent';
// }
// else {
//     echo 'failed';
// }
//
// if(mail("tncedric@yahoo.com",$subject ,$msg, $headers))
// {
//     echo 'Yahoo sent';
// }
// else {
//     echo 'failed';
// }
?>
