<?php
function Send_Mail($to,$subject,$body)
{
require 'class.phpmailer.php';
$from = "team@yogintechnologies.com";
$mail = new PHPMailer();
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
$mail->IsSMTP(true); // SMTP
$mail->SMTPAuth   = true; // SMTP authentication
$mail->SMTPSecure = 'none'; // secure transfer enabled REQUIRED for Gmail
$mail->Mailer = "smtp";
$mail->Host       = "mail.yogintechnologies.com"; // Amazon SES server, note "tls://" protocol
$mail->Port       = 25;                    // set the SMTP port
$mail->Username   = "team@yogintechnologies.com";  // SES SMTP  username
$mail->Password   = "Yogintech04";  // SES SMTP password
$mail->SetFrom($from, 'Admin');
$mail->AddReplyTo($from,'Admin');
//  $mail->AddAddress('whoto@otherdomain.com', 'John Doe');
//  $mail->SetFrom('name@yourdomain.com', 'First Last');
//  $mail->AddReplyTo('name@yourdomain.com', 'First Last');
//$mail->AddAttachment('images/phpmailer.gif');      // attachment
//  $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
$mail->Subject = $subject;
$mail->MsgHTML($body);
$address = $to;
$address_bcc = "reema.desai@yogintechnologies.com";
//$address_cc = "mehul.patel@yogintechnologies.com";
$mail->AddAddress($address, $to);
//$mail->AddCC($address_cc);
$mail->AddBCC($address_bcc);
if(!$mail->Send())
return false;
else
return true;

}
?>