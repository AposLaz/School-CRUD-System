<?php
session_start();
// Include config file
require_once('config.php');
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $firstname = $lastname = $adress = $mobile_phone = '';
$username_err = $password_err = $confirm_password_err = $email_err = $firstname_err = $lastname_err = $adress_err = $mobile_phone_err = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["user"]))){
        $username_err = "Please enter a username.";
    }
    else{
        $username = trim($_POST["user"]);
        // Prepare a select statement
        $sql_u = "SELECT * FROM Teacher WHERE USERNAME = '$username' ";
        $res_u = mysqli_query($link, $sql_u) or die(mysqli_error($link));
        
        if(mysqli_num_rows($res_u) > 0){
                $username_err = "This username is already exist.Give a valid username.";
        } else{
                $username = trim($_POST["user"]);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["pwd"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["pwd"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["pwd"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["pwd-repeat"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        if(empty($password_err) && ($password != trim($_POST["pwd-repeat"]))){
            $confirm_password_err = "Password did not match.Try again.";
        }
    }
    

    // Validate FirstName
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter Firstname.";     
    }
    else{

        if(!ctype_alpha(trim($_POST["firstname"]))){
            $firstname_err = "Invalid Character.Try again.";
        }
        else
        {
             $firstname = trim($_POST["firstname"]);
        }
    }

    // Validate LastName
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter Laststname.";     
    }else{

        if(!ctype_alpha((trim($_POST["lastname"])))){
            $lastname_err = "Invalid Character.Try again.";
        }
        else
        {
             $lastname = trim($_POST["lastname"]);
        }
    }



    //Validate Email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email";
    }else{
        $email = (trim($_POST["email"]));
        // Prepare a select statement
        $sql_e = "SELECT * FROM Teacher WHERE EMAIL = '$email' ";
        $res_e = mysqli_query($link, $sql_e) or die(mysqli_error($link));
        
        if(mysqli_num_rows($res_e) > 0){
                $email_err = "This email is already exist.Give a valid email.";
        } elseif(!filter_var((trim($_POST["email"])), FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.Try again.";
        }   
        else{ 
            $email = trim($_POST["email"]);
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
    }elseif(strlen(trim($_POST["mobl"])) != 10){
        $mobile_phone_err = "Mobile-Phone must have at least 10 numbers.";
    }else{
         $mobile_phone = trim($_POST["mobl"]);
        // Prepare a select statement
        $sql_m = "SELECT * FROM Teacher WHERE MOBILE_NUMBER = '$mobile_phone' ";
        $res_m = mysqli_query($link, $sql_m) or die(mysqli_error($link));
        
        if(mysqli_num_rows($res_m) > 0){
                $mobile_phone_err = "This mobile_phone is already exist.Give a other phone.";
        } elseif(!filter_var(trim($_POST["mobl"]),FILTER_SANITIZE_NUMBER_INT)) {
            $mobile_phone_err = "Invalid phone number.Try again.";
        }   
        else{ 
            $mobile_phone = trim($_POST["mobl"]);
        }

    }





    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($adress_err) && empty($mobile_phone_err)){



$sql = "INSERT INTO Teacher (USERNAME, FIRSTNAME, LASTNAME, EMAIL, ADRESS, PASSWORD, MOBILE_NUMBER)VALUES ('$username','$firstname','$lastname','$email','$adress','$password','$mobile_phone')" ;

    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    if($result)
    {
     $_SESSION['success_message'] = "Your account created succesfully.";
    }
    else
    {
     echo "Oups try later";
    }

    }
}
mysqli_close($link);
?>
 
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html" charset="utf-8">
	<title>Congratulation</title>
	<link rel="stylesheet" type="text/css" href="css/reg.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Play">
</head>

<body>
	<div class="signup signup-med1">
		<form class="form-inline" action="register.php"  method="post">
            <?php if (isset($_POST['sub'])) { if(isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])){ ?>
                        <div class="success-message" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
                        <?php
                      }  
                      unset($_SESSION['success_message']);
                    }
                    ?>
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
            <br><br>
			<input name="sub" type="submit" value="Sign Up!" ><br><br>
			
				<span style="margin-left:;">Already have an account?</span><a href="index.php" style="text-decoration: none;font-family: 'Play',sans-serif; color: #2196F3;">&nbsp;Log In</a>
		</form>
	</div>

</body>
</html>
