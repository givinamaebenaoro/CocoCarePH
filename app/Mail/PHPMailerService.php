<?php

namespace App\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerService
{
    public function sendVerificationEmail($user, $verificationToken)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server address
            $mail->SMTPAuth = true;
            $mail->Username = 'phcococare@gmail.com'; // Your SMTP username
            $mail->Password = 'lxrmcxprxnljnhma'; // Your SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('phcococare@gmail.com', 'CocoCare');
            $mail->addAddress($user->email, $user->name); // User's email address and name

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body    = 'Please click the following link to verify your email: <a href="'.route('verify', $verificationToken).'">Verify Email</a>';

            $mail->send();
        } catch (Exception $e) {
            // Handle the error appropriately in your application
            throw new \Exception("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}
