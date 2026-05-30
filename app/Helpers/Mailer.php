<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static function send($to, $subject, $body)
    {
        $mail = new PHPMailer(true);
        try {
            // Server settings (usually from config)
            $mail->isSMTP();
            $mail->Host       = 'localhost'; // Configure as needed
            $mail->SMTPAuth   = false;
            $mail->Port       = 1025; // MailHog default

            // Recipients
            $mail->setFrom('noreply@swiffy.dev', 'Swiffy Code');
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Log error
            error_log("Mailer Error: " . $mail->ErrorInfo);
            return false;
        }
    }
}
