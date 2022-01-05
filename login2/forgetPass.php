<?php
session_start();
require_once('config.php');

$email_err = '';
if($_SERVER["REQUEST_METHOD"] == "POST"){
if (isset($_POST["send_mail"]))
{

	if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email";
    }
    	elseif(!filter_var((trim($_POST["email"])), FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.Try again.";
		}
    else
    {
	$selector = bin2hex(random_bytes(8));
	$token = random_bytes(32);

	$url = "localhost/login2/resetpas.php?selector=" . $selector . "&validator=" .
	bin2hex($token);

	$expires = date("U") + 1800;

	require_once('config.php');

	$userEmail = $_POST["email"];

	$sql = "DELETE FROM pwdReset WHERE pwdResetEmail=? ";
	$stmt = mysqli_stmt_init($link);

	if(!mysqli_stmt_prepare($stmt, $sql))
	{
		echo "There was an error.Try later!";
		exit();
	}
	else
	{
		mysqli_stmt_bind_param($stmt, "s", $userEmail);
		mysqli_stmt_execute($stmt);
	}

	$sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";

	$stmt =mysqli_stmt_init($link);
	if(!mysqli_stmt_prepare($stmt, $sql))
	{
		echo "There was an error.Try later!";
		exit();
	}
	else
	{
		$hashedToken = password_hash($token, PASSWORD_DEFAULT);
		mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
		mysqli_stmt_execute($stmt);
	}

	mysqli_stmt_close($stmt);
	mysqli_close($link);

	$to = $userEmail;

	$subject = 'Rest your password for teach';

	$message = '<p>We received a password reset request.The link to reset your password is below.If you do not make this request,you can ignore this email</p>';
	$message .= '<p>Here is your password reset link: </p>';
	$message .= '<a href="' .$url . '">' . $url . '</a></p>';

	$headers = "From: aplaz <aplazidis@gmail.com>\r\n";
	$headers .= "Reply-To: aplazidis@gmail.com\r\n";
	$headers .= "Content-type: text/html\r\n";

	mail($to, $subject, $message ,$headers);

	$msg = "A mesage send to your account successfully.!!!";
	header("Location: index.php?msg=".$msg);
	//header("Location: resetpas.php");
}
}
else
{
	("Location: index.php");
}

}
mysqli_close($link);

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html" charset="utf-8">
	<title>Forgot Password</title>
	<link rel="stylesheet" type="text/css" href="css/forget.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Play">
</head>

<body>
	<div class="forgetPass">
		<form action="forgetPass.php" method="post">
			<h2 align="center" style="color: #fff">Forget Password</h2>
			<h5 align="center" style="font-size: 14px; color: #2196F3">Enter email here that you used on your account.We send link on your email to reset your password.</h5>
			
			<div class="<?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
				<input type="text" name="email" placeholder="Enter your email"><br>
				<span class="help-block" style="font-size:12px;margin-left:15%;margin-top:-17px;"><?php echo $email_err; ?></span>
			</div><br>
			<div class="fs">
				<input class="fs" type="submit" name="send_mail" value="Send"><br><br><br>
			</div>
			<a href="index.php" style="text-decoration: none; margin-left: 10%;margin-right: 10%; color:#2196F3">Go back to Home page</a><br><br>

			
		
			
		</form>


	</div>


</body>
</html>