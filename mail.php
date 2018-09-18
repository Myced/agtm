<?php


//try now with php mailer
require 'PHPMailer/PHPMailerAutoload.php';



//Create a new PHPMailer instance
$mail = new PHPMailer;

//Enable SMTP debugging.
$mail->SMTPDebug = 3;
//Set PHPMailer to use SMTP.
$mail->isSMTP();
//Set SMTP host name
$mail->Host = "smtp.gmail.com";
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;
//Provide username and password
$mail->Username = "tncedric@gmail.com";
$mail->Password = "a73901939a";
//If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "tls";
//Set TCP port to connect to
$mail->Port = 587;

//From email address and name
$mail->From = "accounts@a-gtm.com";
$mail->FromName = "AGTM Accounts";

//To address and name
$mail->addAddress("tncedric@yahoo.com", "Recepient Name");

//Address to which recipient will reply
$mail->addReplyTo("accounts@a-gtm.com", "Reply");

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Email Confirmation";
$mail->Body = "<i>Mail body in HTML</i>";
$mail->AltBody = "This is the plain text version of the email content";

if(!$mail->send())
{
    echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
    echo "Message has been sent successfully";
}
?>
