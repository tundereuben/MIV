//Ajax Call for the request instructor form up form 
//Once the form is submitted
$("#contact").submit(function(event){ 
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
    //send them to signup.php using AJAX
    $.ajax({
        url: "contact.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#contactformmessage").html(data);
            }
        },
        error: function(){
            $("#contactformmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            
        }
    
    });

});