<?php
exit(); // do nothing
$to      = 'george@corser.com';
$subject = 'svsu/fr registration';
$message = 'click this link to confirm';
$headers = 'From: gpcorser@svsu.edu' . "\r\n" .
    'Reply-To: gpcorser@svsu.edu' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>