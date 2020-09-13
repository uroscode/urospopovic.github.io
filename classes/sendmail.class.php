<?php

class Sendmail {
    public $error = false;
    protected  $private_key = "6Lfnq8IZAAAAAIbIKTpYgx2pIL5YhyNBPTAP1dJo";

    public function SendTheMail($name,$email,$message){
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;

        //**reCAPTCHA**//
        $gResponse = $_POST['g-recaptcha-response'];
        $user_ip = $_SERVER['REMOTE_ADDR'];

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$this->private_key."&response=".$gResponse."&remoteip=".$user_ip;
        $gResponse = file_get_contents($url);
        $gResponse = json_decode($gResponse);


        //**NAME VALIDATION**//
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $this->error = true;
            $response = array(
                'response' => "error_name",
                'content' => "Only letters and spaces allowed!",
            );
        //**EMAIL VALIDATION**//
        }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->error = true;
            $response = array(
                'response' => "error_email",
                'content' => "Please enter a valid email adress!",
            );
            //**SEND MAIL**//
        }else if($gResponse->success){
                    $to = 'urospopovicco@gmail.com';
                    $subject = "Portfolio | Uros Popović";
                    $messageFrom = $message;
                    $headers = "From: " . $email;

                    $mail = mail($to,$subject,$messageFrom,$headers);

                    if($mail && $this->error == false){
                        $response = array(
                            'response' => "success",
                            'content' => "Email has been successfully sended!",
                        );
                    }else{
                        $this->error = true;
                        $response = array(
                            'response' => "error",
                            'content' => "There was an error while sending a message!",
                        );
                    }

            }else{
                $this->error = true;
                $response = array(
                    'response' => "error",
                    'content' => "Please fill in reCaptcha!",
                );
            }
        //**RETURN VALUE**//
        echo json_encode($response);
    }

}

?>