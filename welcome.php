<?php
session_start();
require_once "database.php";


if (!isset($_SESSION["email"])) {
  header("Location: login_page.php");
  exit();
}

$userEmail = $_SESSION["email"];

$result = mysqli_query($connection, "SELECT * FROM details WHERE email = '$userEmail'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
  header("Location: login_page.php");
  exit();
}

$fullName = $row['full_name'];
$dateOfBirth = $row['date_of_birth'];
$gender = $row['gender'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style_1.css">
</head>
<body method="post">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <img class="navbar-brand" src="https://www.98thpercentile.com/hs-fs/hubfs/98thlogo.png?width=1035&height=528&name=98thlogo.png" width="200px" height="100px" alt="98th_Percentile" >
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="update_profile.php">Profile</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="Welcome.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
              Programs
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Math</a></li>
              <li><a class="dropdown-item" href="#">English</a></li>
              <li><a class="dropdown-item" href="#">Coding</a></li>
              <li><a class="dropdown-item" href="#">Public Speaking</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
              Student Corner
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Contests</a></li>
              <li><a class="dropdown-item" href="#">Success Stories</a></li>
              <li><a class="dropdown-item" href="#">ElevatEd (Blog)</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
        </ul>
    </div>
  </div>
</nav>
<form>
<div class="card">
<div class="card-body">
    <h3 class="card-title"><b>Welcome!</b> <?=$fullName ?></h3>
</div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><h6>Your Email is: <?php echo $userEmail . "."; ?></h6></li>
    <li class="list-group-item"><h6>Date Of Birth: <?php echo $dateOfBirth . "."; ?></h6></li>
    <li class="list-group-item"><h6>Gender: <?php echo $gender; ?><h6></li>
  </ul>
</div>
</form>
</body>
</html>