<?php
session_start();
$profil=$_SESSION['user'];
if($profil != true)
{
    header("Location: index.php");
}
else
{
	require_once('config.php');
	$username = $id  = $password = $confirm_password = $email = $firstname = $lastname = $adress = $mobile_phone = '';
	$username_err = $password_err = $confirm_password_err = $email_err = $firstname_err = $lastname_err = $adress_err = $mobile_phone_err = '';


	$sql = "SELECT * FROM Teacher WHERE USERNAME = '$profil' OR EMAIL= '$profil' ";
	$result = mysqli_query($link, $sql) or die(mysqli_error($link));
	$row = mysqli_fetch_assoc($result);

	$id = $row['ID'];
	$username = $row['USERNAME'];
	$email = $row['EMAIL'];
	$firstname = $row['FIRSTNAME'];
 	$lastname = $row['LASTNAME'];
 	$adress = $row['ADRESS'];
 	$mobile_phone = $row['MOBILE_NUMBER'];
 	$password = $row['PASSWORD'];

 	//-----------------------------------------CHECK AND UPDATE--------------------------------//

 	if($_SERVER["REQUEST_METHOD"] == "POST"){
 	
 	if(isset($_POST['btn-reg'])){
    // Validate username
    if(empty(trim($_POST["user"]))){
        $username_err = "Please enter a username.";
    }
    else{
        $uusername = trim($_POST["user"]);
        // Prepare a select statement
        $sql_u = "SELECT * FROM Teacher WHERE USERNAME = '$uusername' ";
        $res_u = mysqli_query($link, $sql_u) or die(mysqli_error($link));
        
        if ($username != $uusername) {
        	if(mysqli_num_rows($res_u) > 0){
                $username_err = "This username is already exist.Give a valid username.";
        	} else{
                $new_username =  trim($_POST["user"]);
       		 }
        }
        else
        {
        	$new_username =  trim($_POST["user"]);
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
             $new_firstname =  trim($_POST["firstname"]);
        }
    }

    // Validate LastName
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter Laststname.";     
    }else{

        if(!ctype_alpha(trim($_POST["lastname"]))){
            $lastname_err = "Invalid Character.Try again.";
        }
        else
        {
             $new_lastname =  trim($_POST["lastname"]);
        }
    }



    //Validate Email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email";
    }else{
        if ($email !=  trim($_POST["email"])) {
        	$eemail = trim($_POST["email"]);
        // Prepare a select statement
       		 $sql_e = "SELECT * FROM Teacher WHERE EMAIL = '$eemail' ";
       		 $res_e = mysqli_query($link, $sql_e) or die(mysqli_error($link));
       		 	if(mysqli_num_rows($res_e) > 0){
                	$email_err = "This email is already exist.Give a valid email.";
       			 } elseif(!filter_var((trim($_POST["email"])), FILTER_VALIDATE_EMAIL)) {
            		$email_err = "Invalid email format.Try again.";
       			 }   
        		else{ 
            		$new_email =  trim($_POST["email"]);
       			 }
        }
        else{ 
            		$new_email =  trim($_POST["email"]);
       		 }
    }

    //Validate Adress
    if(empty(($_POST["adress"]))){
        $adress_err = "Please enter an Adress";
    }else{
        $new_adress =  trim($_POST["adress"]);
    }

    //Validate Mobile-Phone
    if(empty(trim($_POST["mobl"]))){
        $mobile_phone_err = "Please enter a Mobile-Phone";
    }elseif(strlen(trim($_POST["mobl"])) != 10){
        $mobile_phone_err = "Mobile-Phone must have at least 10 numbers.";
    }else{
        if ($mobile_phone != trim($_POST["mobl"])) {

        	$mmobile_phone = trim($_POST["mobl"]);
       		 // Prepare a select statement
       		 $sql_m = "SELECT * FROM Teacher WHERE MOBILE_NUMBER = '$mmobile_phone' ";
        	$res_m = mysqli_query($link, $sql_m) or die(mysqli_error($link));

        	if(mysqli_num_rows($res_m) > 0){
               	 $mobile_phone_err = "This mobile_phone is already exist.Give an other phone.";
        	} elseif(!ctype_digit(trim($_POST["mobl"]))) {
            	$mobile_phone_err = "Invalid phone number.Try again.";
        	}   
        	else{ 
            	$new_mobile_phone =  trim($_POST["mobl"]);
       		 }
        		
        } 
        else{ 
            $new_mobile_phone = trim($_POST["mobl"]);
        }

   	 }



    // Check input errors before inserting in database
    if(empty($username_err) && empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($adress_err) && empty($mobile_phone_err)){


	$sqlq = "UPDATE Teacher SET USERNAME='$new_username', FIRSTNAME='$new_firstname' , LASTNAME='$new_lastname', EMAIL = '$new_email', ADRESS = '$new_adress', MOBILE_NUMBER='$new_mobile_phone' WHERE ID = '$id'";

    $resultq = mysqli_query($link, $sqlq) or die(mysqli_error($link));
    if($resultq)
    {
    	$_SESSION['user'] = $_POST['user'];
      $_SESSION['success_message'] = "Your account updated successfully.Refresh the page!!!";
    }
    else
    {
     echo "Oups try later";
    }

    }
}
}


}

?>


<?php
include('header.php');

?>



<!DOCTYPE html>
<html>
<head>
    <title>SchoolSystem/Update</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/updProfil.css" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>



</head>

<body style="background-color:white;">
<div class=container-for-all style="background-color: #e5e5c7;">
	<form action="UpdateProfile.php" method="post">
  		<div class="container">
        <?php  if(isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])){ ?>
                        <div class="success-message" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
                        <?php
                      }  
                    else
                    {
                      if(isset($_SESSION['pass_message']) && !empty($_SESSION['pass_message']))
                      { ?>
                        <div class="success-message" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['pass_message']; ?></div>
                        <?php
                      }
                    }
                    unset($_SESSION['success_message']);
                    unset($_SESSION['pass_message']);
                  
                    ?>
    <h1>SETTINGS</h1>
    <p>Make changes to your profile.</p>
    <hr>
	<div class="cont1" >
	<div class="fs">
		<div class="<?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
			<label for="user"><b>Username</b></label>
			<br>
			<input type="text" value="<?php echo $username; ?>" name="user" placeholder="Enter Username">
		 	<span style="margin-top:-7px;" class="help-block"><?php echo $username_err; ?></span>
		</div>
		<div class="<?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
			<label for="email"><b>Email</b></label>
			<br>
			<input placeholder="Enter Email" type="text" value="<?php echo $email; ?>" name="email" >
			<span style="margin-top:-7px;" class="help-block"><?php echo $email_err; ?></span>
		</div>
		<div class="<?php echo (!empty($adress_err)) ? 'has-error' : ''; ?>">
			<label for="adress"><b>Adress</b></label>
			<br>
			<input placeholder="Enter Adress" type="text" value="<?php echo $adress; ?>" name="adress" >
			<span style="margin-top:-7px;" class="help-block"><?php echo $adress_err; ?></span>
		</div>
	</div>
	
	<div class="fs">
		<div class="<?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
			<label for="firstname"><b>Firstname</b></label>
			<br>
			<input type="text" value="<?php echo $firstname; ?>" name="firstname" placeholder="Enter Firstname">
		 	<span style="margin-top:-7px;" class="help-block"><?php echo $firstname_err; ?></span>
		</div>
		<div class="<?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
			<label for="lastname"><b>Lastname</b></label>
			<br>
			<input type="text" value="<?php echo $lastname; ?>" name="lastname" placeholder="Enter Lastname">
			<span style="margin-top:-7px;" class="help-block"><?php echo $lastname_err; ?></span>
		</div>
		<div class="<?php echo (!empty($mobile_phone_err)) ? 'has-error' : ''; ?>">
			<label for="mobile_numb"><b>Mobile number</b></label>
			<br>
			<input placeholder="Enter Mobile Number" type="text" value="<?php echo $mobile_phone; ?>" name="mobl" >
			<span style="margin-top:-7px;" class="help-block"><?php echo $mobile_phone_err; ?></span>
		</div>
		
	</div>	
	</div>
	<div class="fs2">
		<hr>
		<button type="submit" name="btn-reg" class="registerbtn" style="float:right;">Apply Changings</button>
    <a href="ChangePassword.php" style="width:30%;padding: 16px 20px;background-color:red;border: none;cursor: pointer;border-radius:7px;text-decoration: none;text-align:center;display: inline-block;color: white;opacity: 0.9;">Change Password</a>
	</div>
  		
  </div>
</form>
</div>



</body>
</html>