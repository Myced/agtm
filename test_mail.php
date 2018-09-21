<?php
include_once 'mail.php';

$full_name = 'Cedric Ndi';
$link = $confirm_link = "http://www.a-gtm.com/confirm_email.php?token=nditifuh";

$to = 'tncedric@gmail.com';

include_once 'mail_template.php';

//send the test email
if(mail($to ,$subject ,$mymail, $headers))
{
    echo 'email sent';
}
else {
    echo 'email failed';
}
 ?>
