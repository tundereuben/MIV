<?php
//<!--Start Session-->
session_start();
include('connection.php');
 
//Set the errors,username, email, password variables as a global variable else it triggers an error message on screen.
global $errors, $firstname, $surname, $email, $phone;

//<!--Check User inputs--> 
//    <!--Define error messaages-->
$missingfirstName = '<p>Please enter a Firstname!</p>';
$missingsurName = '<p>Please enter a Surname!</p>';
$missingEmail = '<p>Please enter your email address!</p>';
$invalidEmail = '<p>Please enter a valid email address</p>';
$missingPhone = '<p>Please enter your phone number!</p>';
$missingLocation = '<p>Please enter your location!</p>';
$missingGender = '<p>Please pick your gender!</p>';


//    <!--Get firstname, surname, email, phone-->
//GEt firstname
if(empty($_POST["firstname"])){
    $errors .=$missingfirstName;
}else{
    $firstname = filter_var($_POST["firstname"], FILTER_SANITIZE_STRING);
}
//Get surname
if(empty($_POST["surname"])){
    $errors .=$missingsurName;
}else{
    $surname = filter_var($_POST["surname"], FILTER_SANITIZE_STRING);
}
//Get Email
if(empty($_POST["email"])){
    $errors .= $missingEmail;
}else{
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= $invalideEmail;
    }
}
//Get phone
if(empty($_POST["phone"])){
    $errors .= $missingPhone;
}else{
    $phone = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
}

//Get location
if(empty($_POST["location"])){
    $errors .= $missingLocation;
}else{
    $location = filter_var($_POST["location"], FILTER_SANITIZE_STRING);
}

//Get gender
if(empty($_POST["gender"])){
    $errors .= $missingGender;
}else{
    $gender = filter_var($_POST["gender"], FILTER_SANITIZE_STRING);
}

//Get accomodation
if(empty($_POST["accomodation"])){
//    $errors .= $missing;
}else{
    $accomodation = filter_var($_POST["accomodation"], FILTER_SANITIZE_STRING);
}

//if there are any errors print error
if($errors){
    $resultMessage = '<div class="alert alert-danger">' .$errors . '</div>';
    echo $resultMessage; 
    exit;
}

//No errors

//prepare variables for the queries
$firstname = mysqli_real_escape_string($link, $firstname);
$surname = mysqli_real_escape_string($link, $surname);
$email = mysqli_real_escape_string($link, $email);
$phone = mysqli_real_escape_string($link, $phone);
$location = mysqli_real_escape_string($link, $location);
$gender = mysqli_real_escape_string($link, $gender);
$accomodation = mysqli_real_escape_string($link, $accomodation);


//If email exists in the users table print error.
$sql = "SELECT * FROM leadership_conference_2018 WHERE email = '$email'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>';
    exit;
}
$results = mysqli_num_rows($result);
if($results){
    echo '<div class="alert alert-danger">That email is already registered.</div>'; 
    exit;
}


//Insert registration details into table
$sql = "INSERT INTO leadership_conference_2018 (first_name, sur_name, email, phone, location, gender, accomodation, date) VALUES ('$firstname', '$surname', '$email', '$phone', '$location', '$gender', '$accomodation', now())";

$result = mysqli_query($link, $sql);
if(!$result){
//    echo '<div class="alert alert-danger">There was an error inserting the user details into the database!</div>'; 
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit;
}

// Send mail to MIV upon registration
$message = "
    <html>
        <body style='width:500px; margin:auto'>
            <div class='container' style='background:#990000; padding:10px;font-family:candara; line-height:30px;color:dimgray;'>
                <div style='background:#fff;border:solid 2px dimgray;padding:10px; font-size:1.1em;'>
                    <h3>Message from Website</h3>
                    <p>Name: $firstname</p>
                    <p>Surname: $surname</p>
                    <p>Email: $email</p>
                    <p>Phone: $phone</p>
                    <p>Location: $location</p>
                    <p>Gender: $gender</p>
                    <p>Accomodation: $accomodation</p>
                </div>
            </div>  
          </body>
    </html>
    ";

$headers = "From: no-reply@menofissacharvision.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


if(mail('mivmandate2010@gmail.com, tundeogunjimi@gmail.com', 'New Registration for Leadership Conference', $message, $headers)){
//       echo "<div class='alert alert-success'>Thank you for registering. </div>";
}


$to = $email;

$headers = "From: no-reply@menofissacharvision.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message_to_registrant = "

<html>
  <body style='width:500px; margin:auto'>
   <div class='container' style='background:#990000; padding:10px;font-family:candara; line-height:30px;color:dimgray;'>
      <div class='row' style='background:#fff;border:solid 2px dimgray;padding:10px; font-size:1.1em;'>
          <div class='col-sm-12 body'>
              <p>
                  Dear $firstname $surname,
              </p>
              
              <p>
                  Thank you for registering for the 2018 Leadership Conference.
              </p>
              <p>
                  Kindly make a payment of #3,000 to The Men of Issachar Vision Incorporated Guarantee Trust Bank Account 0106817934 to complete your registration. 

              </p>
              <p style='color:#990000;text-align:center;font-weight:bold'>
                  Then, ensure that you keep your evidence of payment to be presented at the confirmation desk during the conference.
              </p>
              <p>
                  Please note that this registration covers one person.
              </p> 
              <p>
                  You are Raised To Do More!
              </p> 
          </div>
          
          <div class='row footer' style='text-align:center;background:#eee;margin:0;padding:10px;font-size:0.8em; font-style:italic;'>
              <div>
                  <div class='col-sm-12' id='mivlogo'>
                   <img src='http://menofissacharvision.com/images/blue_logo.jpg'>
                   <p>The Men of Issachar Vision Inc.</p>
                   <p>
                       You are receiving this email because <span style='text-decoration:underline;'>$email</span> registered for Leadership Conference 2018 of The Men of Issachar Vision Inc.
                   </p>
               </div>
                <div class='col-sm-12'>
                      <br>
                       <div>
                           <p>Follow Us</p>
                       </div>
                        <a href='https://www.facebook.com/menofissacharvision/' target='_blank'><img src='http://menofissacharvision.com/images/social-fb.png'></a>
                        <a href='https://www.instagram.com/mivupdate/' target='_blank'><img src='http://menofissacharvision.com/images/social-instagram.png'></a>
                        <a href='https://www.youtube.com/channel/UCDf-i4OW2a6TScez37Q3glA/videos?disable_polymer=1' target='_blank'><img src='http://menofissacharvision.com/images/social-youtube.png'></a>
                        <a href='https://twitter.com/MIVupdate' target='_blank'><img src='http://menofissacharvision.com/images/social-twitter.png'></a>
                    </div> 

                    <div class='col-sm-12'>
                        <p>&copy; Men of Issachar Vision Inc. | All rights reserved.</p>
                    </div>
                </div>  
            </div>
          
      </div>
      
        
                   
   </div>   
    
      
    
  </body>
</html>
"
;
    
if(mail($to, 'Thanks for Registering', $message_to_registrant, $headers)){
       echo "<div class='alert alert-success'>Thank you for registering. Check your mail for further instructions. </div>";
}
?>