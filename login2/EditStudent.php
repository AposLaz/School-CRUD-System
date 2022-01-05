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

// Define variables and initialize with empty values
	$firstname = $lastname = $fathername = $id = $mobile_phone = $birthday = $grade  = '';
	$firstname_err = $lastname_err = $fathername_err =  $birthday_err = $grade_err = $mobile_phone_err = '';


//EDIT THE STUDENT TAKE THA VALUES
if(isset($_REQUEST['editId'])){
	$key = $_GET['editId'];

	$sql = "SELECT * FROM Students WHERE ID='$key'";
	$result = mysqli_query($link, $sql) or die(mysqli_error($link));
	$row = mysqli_fetch_assoc($result);

	$id = $row['ID'];
	$firstname = $row['FIRSTNAME'];
	$lastname =$row['LASTNAME'];
	$fathername =$row['FATHERNAME'];
	$birthday =$row['BIRTHDAY_DATE'];
	$grade =$row['GRADE'];
	$mobile_phone=$row['MOBILE_NUMBER'];
	
//-----------------------------------------CHECK AND UPDATE--------------------------------//


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
             $upfirstname = trim($_POST["firstname"]);
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
             $uplastname = trim($_POST["lastname"]);
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
             $upfathername = trim($_POST["fathername"]);
        }
    }

    //Validate Email
    if(empty(trim($_POST["birth"]))){
        $birthday_err = "! Please enter a birthday.";
    }else{
        $upbirthday = (trim($_POST["birth"])); 
    }

    //Validate Grades
    if(empty(trim($_POST["grade"]))){
        $grade_err = "! Please enter a grade.";
    }elseif(!(filter_var((trim($_POST["grade"])), FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION))){
        $grade_err = "! Invalide grade.";
    }  
    elseif(trim($_POST["grade"])>10 || trim($_POST["grade"])<0 || strlen(trim($_POST["grade"])) > 2)
	{
		$grade_err ="! Invalide grade.";
	}
    else
    {
    	 $upgrade = floatval(trim($_POST["grade"])); 
    }

    //Validate Mobile-Phone
    if(empty(trim($_POST["mobl"]))){
        $mobile_phone_err = "! Please enter a Mobile-Phone";
    }elseif(strlen(trim($_POST["mobl"])) != 10){
        $mobile_phone_err = "! Mobile-Phone must have at least 10 numbers.";
    }else{
            if ($mobile_phone != trim($_POST["mobl"])) {

            $mmobile_phone = trim($_POST["mobl"]);
             // Prepare a select statement
             $sql_m = "SELECT * FROM Students WHERE MOBILE_NUMBER = '$mmobile_phone' ";
            $res_m = mysqli_query($link, $sql_m) or die(mysqli_error($link));

            if(mysqli_num_rows($res_m) > 0){
                 $mobile_phone_err = "This mobile_phone is already exist.Give an other phone.";
            } elseif(!ctype_digit(trim($_POST["mobl"]))) {
                $mobile_phone_err = "Invalid phone number.Try again.";
            }   
            else{ 
                $upmobile_phone =  trim($_POST["mobl"]);
             }
                
        } 
        else{ 
            $upmobile_phone = trim($_POST["mobl"]);
        }


        }

    

    // Check input errors before inserting in database
    if(empty($firstname_err) && empty($lastname_err) && empty($fathername_err) && empty($email_err) && empty($birthday_err) && empty($grade_err) && empty($mobile_phone_err)){



$sql_m = "UPDATE Students SET FIRSTNAME='$upfirstname',LASTNAME='$uplastname',FATHERNAME='$upfathername',GRADE='$upgrade',MOBILE_NUMBER='$upmobile_phone',BIRTHDAY_DATE='$upbirthday' WHERE ID='$id'" ;

   	 $result1 = mysqli_query($link, $sql_m) or die(mysqli_error($link));
  	  if(isset($result1))
   		 {
            $_SESSION['success_message'] = "Student edited successfully.";
    		 header("Location: teacher.php");
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
    <title>SchoolSystem/Edit</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/addStud.css" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body style="background-color:#ebebe0;">

<form method="post">
  <div class="container" style="background-color: #e5e5c7;">
    <h1>EDIT THE STUDENT</h1>
    <p>Please fill in this form to uptade a Student.</p>
    <hr>
	<div class="cont1" >
	<div class="fs">
		<div class="<?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
			<label for="firstname"><b>Firstname</b></label>
			<br>
			<input type="text" value="<?php echo $firstname; ?>" name="firstname" placeholder="Enter Firstname">
		 	<span style="margin-top:-12px;" class="help-block"><?php echo $firstname_err; ?></span>
		</div>
		<div class="<?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
			<label for="lastname"><b>Lastname</b></label>
			<br>
			<input placeholder="Enter Lastname" type="text" value="<?php echo $lastname; ?>" name="lastname" >
			<span style="margin-top:-12px;" class="help-block"><?php echo $lastname_err; ?></span>
		</div>
		<div class="<?php echo (!empty($birthday_err)) ? 'has-error' : ''; ?>">
			<label for="birthday"><b>Birthday</b></label>
			<br>
			<input placeholder="Enter Birthday Date" type="date" value="<?php echo $birthday; ?>" name="birth" >
			<span style="margin-top:-12px;" class="help-block"><?php echo $birthday_err; ?></span>
		</div>
	</div>
	
	<div class="fs">
		<div class="<?php echo (!empty($fathername_err)) ? 'has-error' : ''; ?>">
			<label for="fathername"><b>Fathername</b></label>
			<br>
			<input placeholder="Enter Fathername" type="text" value="<?php echo $fathername; ?>" name="fathername" >
			<span style="margin-top:-12px;" class="help-block"><?php echo $fathername_err; ?></span>
		</div>
		<div class="<?php echo (!empty($mobile_phone_err)) ? 'has-error' : ''; ?>">
			<label for="mobile_numb"><b>Mobile number</b></label>
			<br>
			<input placeholder="Enter Mobile Number" type="text" value="<?php echo $mobile_phone; ?>" name="mobl" >
			<span style="margin-top:-12px;" class="help-block"><?php echo $mobile_phone_err; ?></span>
		</div>
		<div class="<?php echo (!empty($grade_err)) ? 'has-error' : ''; ?>">
			<label for="grade"><b>Grade</b></label>
			<br>
			<input placeholder="Enter Grade" type="text" value="<?php echo $grade; ?>" name="grade" >
			<span style="margin-top:-12px;" class="help-block"><?php echo $grade_err; ?></span>
		</div>
	</div>	
	</div>
	<div align="center" class="fs2">
		<hr>
		<button type="submit" name="btn-reg" class="registerbtn" style="align:center;">UPDATE</button>
	</div>
  </div>
	

</form>

</body>
</html>