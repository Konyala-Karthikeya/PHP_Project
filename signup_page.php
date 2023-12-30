<?php

$errors = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty($_POST["full_name"])){
        $errors["full_name"] = "* Full Name Required";
    }

    if(empty($_POST["email"])){
        $errors["email"] = "* Email Address Must be Required";
    }

    if(empty($_POST["password"])){
        $errors["password"] = "* Enter the Password";
    } elseif(strlen($_POST["password"]) < 8){
        $errors["password"] = "* Password must be at least 8 characters long";
    }

    if (empty($_POST["confirmPassword"])) {
        $errors["confirmPassword"] = "* Confirm Password is required";
    } elseif ($_POST["password"] !== $_POST["confirmPassword"]) {
        $errors["confirmPassword"] = "* Passwords do not match";
    }

    if (empty($_POST["date_of_birth"])) {
        $errors["date_of_birth"] = "* Date of Birth is required";
    }

    if (empty($_POST["gender"])) {
        $errors["gender"] = "* Gender is required";
    } 

    if (empty($_POST["terms"])) {
        $errors["terms"] = "* You must agree to the Terms and Conditions";
    }

    if(empty($errors)){

       require_once "database.php";
        
        $query = "INSERT INTO details (full_name, email, password, date_of_birth, gender, terms) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param($stmt, "ssssss", $_POST["full_name"], $_POST["email"], $_POST["password"], $_POST["date_of_birth"], $_POST["gender"], $_POST["terms"]);
        if(mysqli_stmt_execute($stmt)){
            $user_id = mysqli_insert_id($connection);
            header("Location:login_page.php?id = $user_id");
            exit();
        } else {
            $errors[] = "Error inserting user data" . mysqli_error($connection);
        }
        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
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
                  <a class="nav-link" href="login_page.php">Login</a>
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
                        <h2 class="text-center">Signup Form</h2>
                    </div>

                    <div class="form-group">
                        <label for="full_name">Full Name:</label>
                        <input name="full_name" placeholder="Enter Full Name" type="text" class="form-control" id="full_name">
                        <?php
                        if(isset($errors["full_name"])) {
                            echo '<div class="error-message">' . $errors["full_name"] . '</div>';
                        }
                        ?>
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
                        <input name="password" placeholder="Enter Password" type="password" class="form-control" id="password">
                        <?php
                        if (isset($errors["password"])) {
                            echo '<div class="error-message">' . $errors["password"] . '</div>';
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password:</label>
                        <input name="confirmPassword" placeholder="Enter Confirm Password" type="password" class="form-control" id="confirmPassword">
                        <?php
                        if (isset($errors["confirmPassword"])) {
                            echo '<div class="error-message">' . $errors["confirmPassword"] . '</div>';
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth:</label>
                        <input name="date_of_birth" type="date" class="form-control" id="date_of_birth">
                        <?php
                        if (isset($errors["date_of_birth"])) {
                            echo '<div class="error-message">' . $errors["date_of_birth"] . '</div>';
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label>Gender:</label>
                        <div class="form-check">
                            <input name="gender" type="radio" class="form-check-input" value="male" id="male">
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check">
                            <input name="gender" type="radio" class="form-check-input" value="female" id="female">
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                        <div class="form-check">
                            <input name="gender" type="radio" class="form-check-input" value="other" id="other">
                            <label class="form-check-label" for="other">Others</label>
                        </div>
                        <?php
                        if (isset($errors["gender"])) {
                            echo '<div class="error-message">' . $errors["gender"] . '</div>';
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input name="terms" type="checkbox" class="form-check-input" id="terms">
                            <label class="form-check-label" for="terms">I agree to the Terms and Conditions</label>
                        </div>
                        <?php
                            if (isset($errors["terms"])) {
                                echo '<div class="error-message">' . $errors["terms"] . '</div>';
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-warning">Signup</button>
                        <!-- <label><a href="login_page.php">Already User!</a></label> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
   