<?php
class Mail
{

    public function send_mail($name, $email, $sub, $msg, $phone)
    {
        $to = 'the.programmer.bro145@gmail.com';
        $form = $email;
        $subject = $sub;
        $message = 'Name: ' . $name . "\r\n" . $msg;
        $headers = 'From: ' . $form . "\r\n" .
            'Reply-To: ' . $form . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }
}
