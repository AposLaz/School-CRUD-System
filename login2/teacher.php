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

$tmp = 0;
if(isset($_POST['search-btn']))
{
  if(ctype_digit(trim($_POST['search-btn'])) && (trim($_POST['search-btn']) > 10 || strlen(trim($_POST['search-btn'])) > 2) )
  {
      $searchKey = $_POST['search-btn'];
      $keyss = explode(" ",$searchKey);
      $sql = "SELECT * FROM Students WHERE MOBILE_NUMBER LIKE '%$searchKey%' OR BIRTHDAY_DATE LIKE '%$searchKey%' ";

      foreach($keyss as $k){
        $sql .= " OR MOBILE_NUMBER LIKE '%$k%' OR BIRTHDAY_DATE LIKE '%$k%' ORDER BY FIRSTNAME ";
      }
    
  }
  elseif (ctype_digit(trim($_POST['search-btn'])) && strlen(trim($_POST['search-btn'])) == 1) {
        $searchKey = $_POST['search-btn'];
        $sql = "SELECT * FROM Students WHERE GRADE LIKE '$searchKey%' ORDER BY GRADE ";
  }
  elseif(is_numeric(trim($_POST['search-btn'])))
  { 
        $searchKey = $_POST['search-btn'];
        $keyss = explode(" ",$searchKey);
        $sql = "SELECT * FROM Students WHERE GRADE LIKE '%$searchKey%' ";

        foreach($keyss as $k){
          $sql .= " OR GRADE LIKE '%$k%' ORDER BY GRADE DESC";
          }
  }
  else
  {
   $searchKey = $_POST['search-btn'];
   $keyss = explode(" ",$searchKey);
   $sql = "SELECT * FROM Students WHERE FIRSTNAME LIKE '%$searchKey%' OR LASTNAME LIKE '%$searchKey%' OR BIRTHDAY_DATE LIKE '%$searchKey%' ";

    foreach($keyss as $k){
     $sql .= " OR FIRSTNAME LIKE '%$k%' OR LASTNAME LIKE '%$k%' OR BIRTHDAY_DATE LIKE '%$k%' ORDER BY FIRSTNAME ";
     } 
  }  
}
else{
  $sql = "SELECT * FROM Students ORDER BY FIRSTNAME";
  $searchKey = "";
}
$result = mysqli_query($link, $sql) or die(mysqli_error($link));
$count = mysqli_num_rows($result);
}
?>

<?php

include('header.php');
mysqli_close($link);

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome SchoolSystem Home</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet"  href="css/cong.css">
<script src="jquery.js"></script>


<script type="text/javascript">
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>


</head>
<body style="background-color:#e5e5c7;">
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
                        <div class="success-message" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
                        <?php
                        unset($_SESSION['success_message']);
                    }
                    ?>
                <div class="row">
                    <div class="col-sm-8"><h2>Students <b>Details</b></h2><br><p>There is/are <b><?php echo "$count Students"; ?></b></p></div> 
          
                    <div class="col-sm-4">
                      <form action="" method="post">
                        <div class="search-box">
                            <i class="material-icons">&#xE8B6;</i>
                            <input type="text" id="search_text" name="search-btn" value="<?php echo $searchKey; ?>" class="form-control" placeholder="Search&hellip;">
                        </div>
                      </form>
                    </div>
                </div>
            </div>
            <div class="result">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>FIRSTNAME </th>
                        <th>LASTNAME</th>
                        <th>FATHERNAME </th>
                        <th>BIRTHDAY DATE</th>
                        <th>MOBILE NUMBER </th>
                        <th>GRADE </th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </tr>
                </thead>
                <tbody>
                  <?php if(mysqli_num_rows($result) > 0)
                    {while( $row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo ++$tmp; ?></td>
                        <td><?php echo $row['FIRSTNAME']; ?></td>
                        <td><?php echo $row['LASTNAME']; ?></td>
                        <td><?php echo $row['FATHERNAME']; ?></td>
                        <td><?php echo $row['BIRTHDAY_DATE']; ?></td>
                        <td><?php echo $row['MOBILE_NUMBER']; ?></td>
                        <td><?php echo $row['GRADE']; ?></td>
                        <td>
                            <a  href="EditStudent.php?editId=<?php echo $row['ID'];?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                        </td>
                        <td> 
                            <a  href="DeleteStud.php?delId=<?php echo $row['ID'];?>"  class="delete" title="Delete" data-toggle="tooltip" onClick="return confirm('Are you sure to delete this user?');"><i class="material-icons">&#xE872;</i></a>
                        </td>
                        <?php endwhile; } else {  ?>
                      
                  </tr>
                </tbody> 
            </table>
            <div align="center">
            <p style="font-size:18px;"><strong>No results from search</strong></p>
            </div>
                  <?php } ?>
          </div>
        </div>
    </div>   

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>  
</body>
</html>                                 
    





