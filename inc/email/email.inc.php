<?php

namespace email;

use config\configManager;

class email {
    private $emailLibary;
    
    function __construct() {
        $config = configManager::getConfig();
        
        $this->emailLibary = new emailLibary();
        $this->emailLibary->isSMTP();
        $this->emailLibary->Host = $config["mail_host"];
        $this->emailLibary->SMTPAuth = true;
        $this->emailLibary->Username = $config["mail_username"];
        $this->emailLibary->Password = $config["mail_password"];
        $this->emailLibary->SMTPSecure = $config["mail_encryption"];
        $this->emailLibary->Port = $config["mail_port"];
        $this->emailLibary->CharSet = 'utf-8';
    }
    function sendHtml($from, $to, $subject, $body, $replyTo = false){
        $this->emailLibary->setFrom($from, 'FRACTAVA');
        $this->emailLibary->addAddress($to);
        
        if($replyTo != false) {
            $this->emailLibary->addReplyTo($replyTo, 'FRACTAVA');
        }
        
        $this->emailLibary->isHTML(true);
        $this->emailLibary->Subject = $subject;
        $this->emailLibary->Body = $body;
        $this->emailLibary->send();
    }
    function sendStyled($from, $to, $subject, $text, $replyTo = false) {
        
        $body = "<html>" .
                    "<body>" .
                        "<div style='background-color: black; width: 100%; min-height: 100%; display: flex; flex-direction: column; align-items: center;'>" .
                            "<img style='width: 20%;' alt='logo' src='https://fractava.com/assets/img/logo/logo_white.png'>" .
                            "<div style='background-color: white; padding: 10px; color: black; min-width: 50%; border-radius: .3125em;'" .
                                "<p>" . $text . "</p>" .
                            "</div>" .
                        "</div>" .
                    "</body>" .
                "</html>";
        
        $this->sendHtml($from, $to, $subject, $body, $replyTo);
    }
}