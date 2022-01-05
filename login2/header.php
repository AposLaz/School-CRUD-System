<?php
$profil=$_SESSION['user'];
if($profil != true)
{
    header("Location: index.php");
}
else
{
$sqle = "SELECT * FROM Teacher WHERE USERNAME = '$profil' OR EMAIL= '$profil' ";
  $resulte = mysqli_query($link, $sqle) or die(mysqli_error($link));
  $rowe = mysqli_fetch_assoc($resulte);
  $firstn = $rowe['FIRSTNAME'];
  $lastnam = $rowe['LASTNAME'];

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet"  href="header.css">

<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>




<script type="text/javascript">
  // Prevent dropdown menu from closing when click inside the form
  $(document).on("click", ".navbar-right .dropdown-menu", function(e){
    e.stopPropagation();
  });
</script>
</head> 

<body>
<nav class="navbar navbar-default navbar-expand-lg navbar-light">
  <div class="navbar-header d-flex col">
    <a class="navbar-brand" href="teacher.php">School<b>System</b></a>     
    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
      <span class="navbar-toggler-icon"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>
  <!-- Collection of nav links, forms, and other content for toggling -->
  <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
    <ul class="nav navbar-nav">
      <li class="nav-item"><a href="teacher.php" class="nav-link">Home</a></li>
      <li class="nav-item"><a href="AddStudent.php" class="nav-link">AddStudent</a></li>      
     
      
  
    </ul>


    <ul class="nav navbar-nav navbar-right ml-auto"> 
      <li class="nav-item">
        <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle get-started-btn mt-1 mb-1"><?php echo $firstn ." ". $lastnam; ?></a>
        <ul class="dropdown-menu form-wrapper">         
          <li>

              <p class="hint-text">Make a choice for your account!</p>
            <form action="UpdateProfile.php" method="post">
              <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="Settings for your account" >
              </div>
            </form>
            <form action="logout.php" method="post" > 
              <input type="submit" class="btn btn-primary1 btn-block" value="Log out">
            </form>
          </li>
        </ul>
      </li>

    </ul>

  </div>
</nav>


</body>
</html>                                                                                    
   
   
    





