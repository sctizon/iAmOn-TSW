<?php

require_once(__DIR__.'/../lib/PHPMailer/src/Exception.php');
require_once(__DIR__.'/../lib/PHPMailer/src/PHPMailer.php');
require_once(__DIR__.'/../lib/PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_mail($dest, $subject, $message) {


    $mail = new PHPMailer();

    // Settings

    $mail->SMTPAutoTLS = false;
    $mail->CharSet = 'UTF-8';

    $mail->Host       = "mail";     // SMTP server example
    $mail->SMTPDebug  = 0;          // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = false;      // enable SMTP authentication
    $mail->Port       = 25;         // set the SMTP port for the GMAIL server

    // Content
    $mail->setFrom('iamon.noreply@gmail.com');   
    $mail->addAddress($dest);

    $mail->isHTML(false);                       // Set email format to HTML
    $mail->Subject =  $subject;
    $mail->Body    = $message;

    try {
        // Configuración del correo electrónico
        $mail->isSMTP();
        // ... (resto de la configuración del correo)

        // Envío del correo electrónico
        if ($mail->send()) { return true; } 
    } catch (Exception $e) { }

    return false;
}
?>