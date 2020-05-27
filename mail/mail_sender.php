<?php
    
    require "PHPMailerAutoload.php";
    
    function sendMail($receiver,$subject,$body){
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = "ger1.fastdirectadmin.com";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = "stocktastik-admin@lampros.ml";
        $mail->Password = "Unpr#d!ct@bl#";
        $mail->setFrom("stocktastik-admin@lampros.ml", "Stocktastik Game");
        $mail->addReplyTo("stocktastik-admin@lampros.ml");
        $mail->isHTML(true);
        $mail->addAddress($receiver);
        $mail->Subject = $subject;
        $mail->Body = $body;
        if(!$mail -> Send()){
            return false;
        }
        else{
            return true;
        }
    }
    
?>