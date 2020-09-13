<?php
header("Content-type:application/json;charset=utf-8");

$document_root = $_SERVER['DOCUMENT_ROOT'];
include_once $document_root.'/portfolio/classes/sendmail.class.php';

if(isset($_POST['g-recaptcha-response'])){

    $sendmailclass = new Sendmail();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message  = trim($_POST['message']);

    $sendmailclass->SendTheMail($name,$email,$message);

}

?>