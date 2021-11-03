<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

require '../config.php';


function sendMail($email, $task)
{
    try {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = '';                     //SMTP username
        $mail->Password = '';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($mail->Username, 'BaiTapLon');
        $mail->addAddress($email);               //Name is optional


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Bạn có công việc " . $task['title'] . " cần hoàn thành trong ngày hôm nay !";
        $mail->Body = "Công việc {$task['title']} cần được hoàn thành vào lúc {$task['deadline_at']}";
        var_dump($mail->Subject);

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

$todayTaskOfUsers = $db->query("SELECT * FROM `tasks` 
LEFT JOIN users ON users.id = tasks.assign_user
LEFT JOIN groups ON groups.group_id = tasks.assign_group
WHERE DATE(`deadline_at`) = CURDATE() AND status != 'DONE'", true);

foreach ($todayTaskOfUsers as $todayTaskOfUser) {
    if ($todayTaskOfUser['email']) {
        sendMail($todayTaskOfUser['email'], $todayTaskOfUser);
    }
}



