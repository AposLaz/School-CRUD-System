<?php

session_start();


if(isset($_POST["reset-pwd"]))
{
	$selector = $_POST["selector"];
	$validator = $_POST["validator"];
	$password = $_POST["pwd"];
	$passwordRepeat = $_POST["pwd-repeat"];

	if(empty($password) || empty($passwordRepeat))
	{
		header("Location: resetpas.php?newpwd=empty");
		exit();
	}
	elseif ($password != $passwordRepeat) {
		header("Location: resetpas.php?newpwd=pwdnotsame");
		exit();
	}

	$currentDate = date("U");

	require_once('config.php');
	$sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";

	$stmt = mysqli_stmt_init($link);

	if(!mysqli_stmt_prepare($stmt, $sql))
	{
		echo "There was an error.Try later!";
		exit();
	}
	else
	{
		mysqli_stmt_bind_param($stmt, "ss", $userEmail, $currentDate);
		mysqli_stmt_execute($stmt);

		$result = msqli_stmt_get_result($stmt);
		if(!$row = mysqli_fetch_assoc($result))
		{
			echo "You need to re-submit your reset request.";
			exit();
		}
		else
		{
			$tokenBin  = hex2bin($validator);
			$tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

			if($tokenCheck == false)
			{
				echo "You need to re-submit your reset request.";
				exit();
			}
			elseif($tokenCheck == true)
			{
				$tokenEmail = $row['pwdRestEmail'];
				$sql = "SELECT * FROM Teacher WHERE EMAIL=?;";
				$stmt = mysqli_stmt_init($link);

				if(!mysqli_stmt_prepare($stmt, $sql))
				{
					echo "There was an error.Try later!";
					exit();
				}
				else
				{
					mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					if(!$row = mysqli_fetch_assoc($result))
					{
						echo "There was an error!!!";
						exit();
					}
					else
					{
						$sql = "UPDATE Teacher SET PASSWORD=? WHERE EMAIL=?";
						$stmt = mysqli_stmt_init($link);

						if(!mysqli_stmt_prepare($stmt, $sql))
						{
							echo "There was an error.Try later!";
							exit();
						}
						else
						{
							$newPwdHash = password_hash($password, PASSWORD_DEFAULT);
							mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
							mysqli_stmt_execute($stmt);
						
							$sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
							$stmt = mysqli_stmt_init($link);
							if(!mysqli_stmt_prepare($stmt, $sql))
							{
								echo "There was an error";
								exit();
							}
							else
							{
								mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
								mysqli_stmt_execute($stmt);
								header("Location: register.php?newpwd=passwordupdated");
							}

						}

					}

				}

			}
		}

	}
}
else
{
	header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html" charset="utf-8">
	<title>Reset Password</title>
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Play">
</head>

<style>

#msg{
	visibility:hidden;
	min-width:250px;
	background-color: #99ff99;
	color: #000;
	text-align: center;
	border-radius:122px;
	padding: 16px;
	position:fixed;
	z-index:1;
	left:33.33%;
	right:30%;
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
	<div class="reset">
		<?php
			$selector = $_GET["selector"];
			$validator = $_GET["validator"];

			if (empty($selector) || empty($validator))
			{
				echo "Could not validate your request!";
			}
			else
			{
				if(ctype_xdigit($selector) != false && ctype_xdigit($validator) !== false)
				{ ?>

		<form action="forgetPass.php" method="post">
			<h2 align="center" style="color: #fff">Reset Password</h2>
			<input type="hidden" name="selector" value="<?php echo $selector ?>">
			<input type="hidden" name="validator" value="<?php echo $validator ?>">
			<input type="password" name="pwd" placeholder="New Password"><br><br>
			<input type="password" name="pwd-repeat" placeholder="Confirm New Password"><br><br><br>
			<input type="button" name="reset-pwd" value="Save" onclick="myFunction()"><br><br><br>
			<a href="index.php" style="text-decoration: none; margin-left: 19%; color: #2196F3">Go back to Home page</a><br><br>
			<div id="msg">Your password changed successfully!!!</div>
			
			<script>
					function myFunction(){
						var x =document.getElementById("msg");
						x.className = "show";
						setTimeout(function(){x.className=x,className.relace("show",""); }, 3000)
					}
				</script>
			
		</form>
		<?php
				}
			}

		?>
	</div>


</body>
</html>