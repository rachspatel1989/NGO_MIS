<?php        
        $to = 'rachana.patel@yogintechnologies.com'; 
        require 'mailer/Send_Mail.php';
        $subject = "Test Mail";
        //$cc = 'gautam.sutaria@yogintechnologies.com';
        $body = "Test of mail sending";
        Send_Mail($to,$subject,$body);                    
?>
