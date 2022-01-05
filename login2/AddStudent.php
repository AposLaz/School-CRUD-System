<?php

session_start();
$profil=$_SESSION['user'];
if($profil != true)
{
    header("Location: index.php");
}
else
{
// Include config file
require_once('config.php');
 
// Define variables and initialize with empty values
$firstname = $lastname = $fathername = $email = $mobile_phone = $birthday = $grade  = '';
$firstname_err = $lastname_err = $fathername_err = $email_err = $birthday_err = $grade_err = $mobile_phone_err = '';

if (isset($_POST['but'])) {

if($_SERVER["REQUEST_METHOD"] == "POST"){ 

    // Validate FirstName
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "! Please enter Firstname.";     
    }
    else{

        if(!ctype_alpha(trim($_POST["firstname"]))){
            $firstname_err = "! Invalid Character.Try again.";
        }
        else
        {
             $firstname = trim($_POST["firstname"]);
        }
    }

    // Validate LastName
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "! Please enter Laststname.";     
    }else{

        if(!ctype_alpha((trim($_POST["lastname"])))){
            $lastname_err = "! Invalid Character.Try again.";
        }
        else
        {
             $lastname = trim($_POST["lastname"]);
        }
    }

    // Validate Fathername
    if(empty(trim($_POST["fathername"]))){
        $fathername_err = "! Please enter Fathername.";     
    }
    else{

        if(!ctype_alpha(trim($_POST["fathername"]))){
            $fathername_err = "! Invalid Character.Try again.";
        }
        else
        {
             $fathername = trim($_POST["fathername"]);
        }
    }

    //Validate Email
    if(empty(trim($_POST["birth"]))){
        $birthday_err = "! Please enter a birthday.";
    }else{
        $birthday = (trim($_POST["birth"])); 
    }

    //Validate Grades
    if(empty(trim($_POST["grade"]))){
        $grade_err = "! Please enter a grade.";
    }elseif(!(filter_var((trim($_POST["grade"])), FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION))){
        $grade_err = "! Invalide grade.";
    }  
    elseif(trim($_POST["grade"])>10 || trim($_POST["grade"])<0)
	{
		$grade_err ="! Invalide grade.";
	}
    else
    {
    	 $grade = floatval(trim($_POST["grade"])); 
    }

    //Validate Mobile-Phone
    if(empty(trim($_POST["mobl"]))){
        $mobile_phone_err = "! Please enter a Mobile-Phone";
    }elseif(strlen(trim($_POST["mobl"])) != 10){
        $mobile_phone_err = "! Mobile-Phone must have at least 10 numbers.";
    }else{
         $mobile_phone = trim($_POST["mobl"]);
        // Prepare a select statement
        $sql_m = "SELECT * FROM Students WHERE MOBILE_NUMBER = '$mobile_phone' ";
        $res_m = mysqli_query($link, $sql_m) or die(mysqli_error($link));
        
        if(mysqli_num_rows($res_m) > 0){
                $mobile_phone_err = "! This mobile_phone is already exist.Give an other phone.";
        } elseif(!filter_var(trim($_POST["mobl"]),FILTER_SANITIZE_NUMBER_INT)) {
            $mobile_phone_err = "! Invalid phone number.Try again.";
        }   
        else{ 
            $mobile_phone = trim($_POST["mobl"]);
        }

    }








    // Check input errors before inserting in database
    if(empty($firstname_err) && empty($lastname_err) && empty($fathername_err) && empty($email_err) && empty($birthday_err) && empty($grade_err) && empty($mobile_phone_err)){



$sql = "INSERT INTO Students (FIRSTNAME, LASTNAME, FATHERNAME, GRADE, MOBILE_NUMBER, BIRTHDAY_DATE)VALUES ('$firstname','$lastname','$fathername','$grade','$mobile_phone','$birthday')" ;

    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    if($result)
    {
        $_SESSION['success_message'] = "Student added successfully!!!";
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
mysqli_close($link);

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SchoolSystem/AddStudent</title>
<link rel="stylesheet" href="css/addStud.css" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body style="background-color:#ebebe0;">

<form action="AddStudent.php" method="post">

  <div class="container" style="background-color: #e5e5c7;">

     <?php if (isset($_POST['but'])) { if(isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])){ ?>
                        <div class="success-message" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
                        <?php
                      }  
                      unset($_SESSION['success_message']);
                    }
                    ?>
    <h1>ADD THE STUDENT</h1>
    <p>Please fill in this form to add a Student.</p>
    <hr>
	<div class="cont1" >
	<div class="fs">
		<div class="<?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
			<label for="firstname"><b>Firstname</b></label>
			<br>
			<input type="text" placeholder="Enter Firstname" name="firstname" >
		 	<span style="margin-top:-12px;" class="help-block"><?php echo $firstname_err; ?></span>
		</div>
		<div class="<?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
			<label for="lastname"><b>Lastname</b></label>
			<br>
			<input type="text" placeholder="Enter Lastname" name="lastname" >
			<span style="margin-top:-12px;" class="help-block"><?php echo $lastname_err; ?></span>
		</div>
		<div class="<?php echo (!empty($birthday_err)) ? 'has-error' : ''; ?>">
			<label for="birthday"><b>Birthday</b></label>
			<br>
			<input type="date" placeholder="Enter Birthday Date" name="birth" >
			<span style="margin-top:-12px;" class="help-block"><?php echo $birthday_err; ?></span>
		</div>
	</div>
	
	<div class="fs">
		<div class="<?php echo (!empty($fathername_err)) ? 'has-error' : ''; ?>">
			<label for="fathername"><b>Fathername</b></label>
			<br>
			<input type="text" placeholder="Enter Fathername" name="fathername" >
			<span style="margin-top:-12px;" class="help-block"><?php echo $fathername_err; ?></span>
		</div>
		<div class="<?php echo (!empty($mobile_phone_err)) ? 'has-error' : ''; ?>">
			<label for="mobile_numb"><b>Mobile number</b></label>
			<br>
			<input type="text" placeholder="Enter Mobile number" name="mobl" >
			<span style="margin-top:-12px;" class="help-block"><?php echo $mobile_phone_err; ?></span>
		</div>
		<div class="<?php echo (!empty($grade_err)) ? 'has-error' : ''; ?>">
			<label for="grade"><b>Grade</b></label>
			<br>
			<input type="text" placeholder="Enter Grade" name="grade" >
			<span style="margin-top:-12px;" class="help-block"><?php echo $grade_err; ?></span>
		</div>
	</div>	
	</div>
	<div align="center" class="fs2">
		<hr>
		<button type="submit" name="but" class="registerbtn" style="align:center;">Register</button>
	</div>
  </div>
	

</form>

</body>
</html>

