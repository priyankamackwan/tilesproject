<?php
error_reporting(E_ALL); 
ini_set("display_errors", 1);
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer();    
    $mail->isSMTP(); 
    $mail->SMTPDebug  = 1;                                    
    $mail->Host = 'smtp.gmail.com';                      
    $mail->SMTPAuth = true;                               
    $mail->Username = 'chirag.webpatriot@gmail.com';     
    $mail->Password = 'chirag@123';                    
    $mail->SMTPOptions = array(
      'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
        'allow_self_signed' => true
        )
    );                         
    $mail->SMTPSecure = 'tls';                           
    $mail->Port = 587;                                   
    $mail->setFrom('chirag.webpatriot@gmail.com');
    $mail->addAddress('chirag.webpatriot@gmail.com');              
    $mail->isHTML(true);                                  
    $mail->Subject = 'Account Activation';
    $mail->Body    = "okay";
    $mail->send();
    if(!$mail){
        echo "email not sent";
    } else {
        echo "email sent";
    }

?>