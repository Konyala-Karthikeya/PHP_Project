<?php
session_start();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $errors["email"] = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format";
    }

    if (empty($_POST["password"])) {
        $errors["password"] = "Password is required";
    }

    if (empty($errors)) {
       
        require_once "database.php";

        if(isset($_POST["submit"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
        
        
            $result = mysqli_query($connection, "SELECT * FROM details WHERE email = '$email' AND password = '$password'");
            $row = mysqli_fetch_assoc($result);
        
        
            if(mysqli_num_rows($result) >= 0){
                if(is_array($row)){
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["password"] = $row["password"];
                    header("Location: welcome.php");
                } else {
                    echo '<script>alert("Invalid email and password")</script>';
                }
            } else {
                echo '<script>alert("user alredy regestried")</script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <img class="navbar-brand" src="https://www.98thpercentile.com/hs-fs/hubfs/98thlogo.png?width=1035&height=528&name=98thlogo.png" width="200px" height="100px" alt="98th_Percentile" >
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link" href="Signup_page.php">Signup</a>
                </li>
              </ul>
          </div>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post">
                    <div class="mt-4">
                        <h2 class="text-center">Login Form</h2>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input name="email" placeholder="Enter Email Address" type="email" class="form-control" id="email">
                        <?php
                        if (isset($errors["email"])) {
                            echo '<div class="error-message">' . $errors["email"] . '</div>';
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input name="password" placeholder="Enter Password" type="password" class="form-control" id="password" min="8">
                        <?php
                        if (isset($errors["password"])) {
                            echo '<div class="error-message">' . $errors["password"] . '</div>';
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember_me">
                            <label class="form-check-label" for="remember_me">Remember me</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-warning">Login</button>
                        <!-- <label>Not a user?<a href="signup_page.php">Register here!</a></label> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>