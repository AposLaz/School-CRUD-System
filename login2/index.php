<?php
session_start();
				


require_once('config.php');

$login = $password = '';
$login_err = $password_err = $login_pass_err =  '';

if($_SERVER["REQUEST_METHOD"] == "POST"){

	if(isset($_POST["login2"]))
	{
		if(empty(trim($_POST["user"])))
		{
			$login_err = "Enter your Username or Email";
		}
		elseif(empty(trim($_POST["pwd"])))
		{
			$password_err = "Enter the password";
		}
		else
		{
			$login = trim($_POST["user"]);
			$password = trim($_POST["pwd"]);
			$sql_u = "SELECT * FROM Teacher WHERE (USERNAME = '$login' OR EMAIL = '$login') && PASSWORD = '$password' ";
			$res_u = mysqli_query($link, $sql_u) or die(mysqli_error($link));
			
			if(mysqli_num_rows($res_u) > 0)
			{
				$_SESSION['user']=$_POST["user"];
				$_SESSION['firstname']=$_POST["firstname"];
				$_SESSION['lastname']=$_POST["lastname"];
				if(isset($_SESSION['user']))
				{
					header("Location: teacher.php");
				}

			}
			else
			{
				$login_pass_err = "Invalid Email/Username or Password.";
			}

		}
	}

}

mysqli_close($link);

?>


<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html" charset="utf-8">
	<title>login and registerForm</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Play">
</head>

<body>
	<div class="signin">
	
	<?php if (isset($_GET['msg'])) {  ?>
                        <div class="success-message" style="text-align:center;margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_GET['msg']; ?></div>
						<?php
						}  
						$msg=NULL;
                
                    ?>

		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
			<h2 style="color: #ffffff">Log in</h2>
			<div class="usermail <?php echo (!empty($login_err)) ? 'has-error' : ''; ?>">
				<input type="text" name="user" placeholder="Enter Username/Email">
				<span class="help-block"><?php echo $login_err; ?></span>
			</div>
			<div class="pass <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
				<input type="password" name="pwd" placeholder="Enter Password">
				<span class="help-block"><?php echo $password_err; ?></span>
			</div><br><br><br>
			<div class="butt <?php echo (!empty($login_pass_err)) ? 'has-error' : ''; ?>" >
				<input type="submit" name="login2" value="Log in"><br>
				<span class="help-block"><?php echo $login_pass_err; ?></span>
			</div>
			<br><br><br>

      		</form>

      		<?php
      			if(isset($_GET["newpwd"]))
      			{
      				if($_GET["newpwd"] == "passwordupdated")
      				{
      					echo '<p class="signupsuccess">Your password has been reset!</p>';
      				}
      			}
      			?>

			<div id="container">
				<!--<a href="resetpas.php" style="margin-right:0; display: inline;font-size:12px;font-family: Tahoma, Gevena, sans-serif;">Reset my password</a>-->
				<a href="forgetPass.php" style="margin-left:10.33%;margin-right:10.33;font-size:17px;font-family: Tahoma, Gevena, sans-serif;">Forgot my password</a>
			</div>
			
			<p style="text-align: center"> Don't have account?<a href="register.php" style="color:#2196F3">&nbsp;Sign Up</a></p>
		
	</div>

</body>
</html>