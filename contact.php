<?php
global $errors;

//Get name
if(empty($_POST["name"])){
    $errors .= "Please enter your name! <br>";
}else{
    $name= filter_var($_POST["name"], FILTER_SANITIZE_STRING);   
}

//Get email
if(empty($_POST["email"])){
    $errors .= "Please enter your email! <br>";  
}else{
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= "Invalid email";   
    }
}


//Get message
if(empty($_POST["message"])){
    $errors .= "Please enter your message <br>";
}else{
    $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
}

if($errors){
    echo "<div class='alert alert-danger'> $errors </div>";
}else{
   $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    //Send the user an email to administrator to notify him of new enquires

    $message_to_mail = "Message from website
        Name: $name
        Email: $email
        Message: $message";

    if(mail('mivmandate2010@gmail.com', 'New Message from MIV Website', $message_to_mail, 'From:'.'MIVContactPage@menofissacharvision.com')){
           echo "<div class='alert alert-success'>Thank you for contacting us! We'll get in touch with you shortly. </div>";
    } 
}

?>