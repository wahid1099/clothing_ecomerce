<?php

// Include PHPMailer library
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = $_ENV['DB_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['DB_USER']; // Replace with your Gmail address
    $mail->Password   = $_ENV['DB_PASSWORD']; // Replace with your Gmail password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    // Sender and recipient settings
    $mail->setFrom($_ENV['DB_USER'], 'Poshak BD'); // Sender's email address and name
    $mail->addAddress('poshaklifestyle0@gmail.com'); // Recipient's email address and name

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body    = 'This is a test email sent using PHPMailer';

    // Send the email
    $mail->send();
    echo 'Email has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
