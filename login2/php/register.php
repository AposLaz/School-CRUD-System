<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $firstname = $lastname = $adress = $mobile_phone ="";
$username_err = $password_err = $confirm_password_err = $email_err = $firstname_err = $lastname_err = $adress_err = $mobile_phone_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["user"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT ID FROM Teach1 WHERE USERNAME = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["user"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.Give a valid name.";
                } else{
                    $username = trim($_POST["user"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["pwd"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["pwd"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["pwd-repeat"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["pwd-repeat"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.Try again.";
        }
    }
    

    // Validate FirstName
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter Firstname.";     
    }
    else{
        $firstname = trim($_POST["firstname"]);

        if(!ctype_alpha($firstname)){
    		$firstname_err = "Invalid Character.Try again.";
    	}
    }

    // Validate LastName
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter Laststname.";     
    }else{
        $lastname = trim($_POST["lastname"]);

        if(!ctype_alpha((trim($_POST["lastname"])))){
    		$lastname_err = "Invalid Character.Try again.";
    	}
    }



    //Validate Email
    if(empty(trim($_POST["email"]))){
    	$email_err = "Please enter an email";
    }else{
    	$email = trim($_POST["email"]);

    	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      		$email_err = "Invalid email format.Try again.";
    	}
    }

    //Validate Adress
    if(empty(trim($_POST["adr"]))){
    	$adress_err = "Please enter an Adress";
    }else{
    	$adress = trim($_POST["adr"]);
    }

    //Validate Mobile-Phone
    if(empty(trim($_POST["mobl"]))){
    	$mobile_phone_err = "Please enter a Mobile-Phone";
    }else{
    	$mobile_phone = trim($_POST["mobl"]);

    	if(!filter_var($mobile_phone,FILTER_SANITIZE_NUMBER_INT)){
    		$mobile_phone_err = "Invalid phone number.Try again.";
    	}
    }





    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err) && empty($emai_err) && empty($adress_err) && empty($mobile_phone_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO Teach1 (USERNAME, EMAIL, FIRSTNAME, LASTNAME, PASSWORDID, ADRESS, MOBILE_NUMBER) VALUES (?, ? ,? ,? ,? ,? ,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_username, $param_email, $param_firstname, $param_lastname, $param_password, $param_adress, $param_mobile_phone);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_firstname = $firstname;
            $param_lastname = $lastname; 
            $param_email = $email;
            $param_adress = $adress;
            $param_mobile_phone = $mobile_phone;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html" charset="utf-8">
	<title>Congratulation</title>
	<link rel="stylesheet" type="text/css" href="css/reg.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Play">
</head>

<style>

#msg{
	visibility:hidden;
	min-width:250px;
	background-color: #99ff99;
	color:#000;
	text-align: center;
	border-radius:211px;
	padding: 16px;
	position:fixed;
	z-index:1;
	right:32%;
	left:33.33%;
	top:30px;
	font-size:17px;
	margin-right: 30px;
}


	#msg.show{
	visibility: visible;
	-webkit-animation: fadein 0.5s,fadeout 0.5s 2.5s;
	animation: fadein 0.5s,fadeout0.5s 2.5s;
}

@-webkit-keyframes fadein{
	from{top:0; opacity:0;}
	to{top:30px;opacity:1;}
}

@-webkit-keyframes fadeout{
	from{top:30px; opacity:1;}
	to{top:0;opacity:0;}
}

@keyframes fadeout{
	from{top: 30px;opacity: 1;}
	to {top:0; opacity: 0;}
}
</style>

<body>
	<div class="signup signup-med1">
		<form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post">
			<h2 style="color: #fff;">Sign Up</h2>
			<div class="fs">
				<div class="fs1 <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>"> 
					<input type="text" name="firstname" placeholder="Firstname">
					 <span class="help-block"><?php echo $firstname_err; ?></span>
				</div>
				<div class="fs2 <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
					<input type="text" name="lastname" placeholder="Lastname">
					 <span class="help-block"><?php echo $lastname_err; ?></span>
				</div>
			</div>
			<br>
			<div class="fs">
				<div class="fs3 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
					<input type="text" name="user" placeholder="Username">
					 <span class="help-block"><?php echo $username_err; ?></span>
				</div>
				<div class="fs4 <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
					<input type="text" name="email" placeholder="Email">
					 <span class="help-block"><?php echo $email_err; ?></span>
				</div>
			</div>
			<br>
			<div class="fs">
				<div class="fs5 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
					<input type="password" name="pwd" placeholder="Password">
					<span class="help-block"><?php echo $password_err; ?></span>
				</div>
				<div class="fs6 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
					<input type="password" name="pwd-repeat" placeholder="Repeat-Password">
					 <span class="help-block"><?php echo $confirm_password_err; ?></span>
				</div>
			</div>
			<br>
			<div class="fs">
				<div class="fs7 <?php echo (!empty($adress_err)) ? 'has-error' : ''; ?>">
					<input type="text" name="adr" placeholder="First Adress">
					 <span class="help-block"><?php echo $adress_err; ?></span>
				</div>
				<div class="fs8 <?php echo (!empty($mobile_phone_err)) ? 'has-error' : ''; ?>">
					<input type="text" name="mobl" placeholder="Mobile-Phone">
					<span class="help-block"><?php echo $mobile_phone_err; ?></span>
				</div>
			</div>
			<br>
			<input type="button" value="Sign Up!" onclick="myFunction()"><br><br>
			
			<label for="remember1">
       			 <input type="checkbox" checked="checked" name="remember"> Remember me
      		</label>
      		<br>
				<div id="msg" style="color:white;">Congratulation you have sign up succesfully!</div>
				<script>
					function myFunction(){
						var x =document.getElementById("msg");
						x.className = "show";
						setTimeout(function(){x.className=x,className.relace("show",""); }, 3000)
					}
				</script>
				<span style="margin-left:;">Already have an account?</span><a href="index.html" style="text-decoration: none;font-family: 'Play',sans-serif; color: #2196F3;">&nbsp;Log In</a>
		</form>
	</div>

</body>
</html>
