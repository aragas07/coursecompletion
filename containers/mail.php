<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

try { 
    $mail->IsSMTP();
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'julius_evan.rivas@dorsu.edu.ph';    
    $mail->Password   = 'P@55w0rd';                 
    $mail->SMTPSecure = 'tls';         
    $mail->Port       = 587;   
    
    $email = $_POST['email'];
    $mail->setFrom('julius_evan.rivas@dorsu.edu.ph','DOrSU grades');
    $mail->addAddress($email);
    $mail->isHTML(true);                                  
    $mail->Subject = "DOrSU";
    $mail->Body    = $_POST['data'];
    $mail->send();
    echo "Send to mail";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}