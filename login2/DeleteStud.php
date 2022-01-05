<?php

session_start();
$profil=$_SESSION['user'];
if($profil != true)
{
    header("Location: index.php");
}
else
{
// Include config file10
require_once('config.php');

if(isset($_REQUEST['delId'])){
	$key = $_GET['delId'];

	$sql = "SELECT * FROM Students WHERE ID='$key'";
	$result = mysqli_query($link, $sql) or die(mysqli_error($link));

	if(mysqli_num_rows($result) > 0)
	{
		$sqlDel = "DELETE from Students WHERE ID = '$key'";
		$result_d = mysqli_query($link, $sqlDel) or die(mysqli_error($link));
		$tmp--;
		if($result_d)
		{
			$_SESSION['success_message'] = "Student deleted successfully.";
     		header("Location: teacher.php");
    	}
    	else
    	{
     		echo "Oups try later";
    	}

	}


}
mysqli_close($link);
}

?>