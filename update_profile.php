<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login_page.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty($_POST["full_name"])){
        $errors["full_name"] = "The updated name required";
    }

    if(empty($_POST["email"])){
        $errors["email"] = "email must be required";
    }

    if(empty($_POST["date_of_birth"])){
        $errors["date_of_birth"] = "The Date of Birth required";
    }

    if (empty($_POST["gender"])) {
        $errors["gender"] = "* Gender is required";
    } 

}

require_once "database.php";

$userEmail = $_SESSION["email"];

$result = mysqli_query($connection, "SELECT * FROM details WHERE email = '$userEmail'");
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST["full_name"];
    $newEmail = $_POST["newEmail"];
    $dateOfBirth = $_POST["date_of_birth"];
    $gender = $_POST["gender"];

    $email_check_query = "SELECT * FROM details WHERE email = '$newEmail' AND email != '$userEmail'";
    $email_check_result = mysqli_query($connection, $email_check_query);
    
    if (mysqli_num_rows($email_check_result) > 0) {
        $errors[] = "Email address is already in use.";
    } else {
        $update_query = "UPDATE details SET full_name = '$fullName', email = '$newEmail', date_of_birth = '$dateOfBirth', gender = '$gender' WHERE email = '$userEmail'";
        mysqli_query($connection, $update_query);

        $_SESSION["email"] = $newEmail;
        header("Location: welcome.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="style_1.css">
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
                  <a class="nav-link" href="welcome.php">Home</a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link" href="update_profile.php">Profile</a>
                </li> -->
                <li class="nav-item">
                  <a class="nav-link" href="login_page.php">Logout</a>
                </li>
              </ul>
          </div>
        </div>
    </nav>
    <center>
        <div class="container">
            <h1 class="text-center">Update Profile, <?php echo $userEmail; ?></h1>
            <?php
                if (!empty($errors)) {
                    echo '<div class="alert alert-danger" role="alert">';
                    foreach ($errors as $error) {
                        echo $error . "<br>";
                    }
                    echo '</div>';
                }
            ?>
            <form method="post">
                <div class="form-group">
                    <label for="full_name" class="form-input">Full Name:</label>
                    <input name="full_name" type="text" class="form-control" id="full_name" value="<?php echo $row['full_name']; ?>">
                    <?php                 
                        if(isset($errors["full_name"])) {
                            echo '<div class="error-message">' . $errors["full_name"] . '</div>';
                        }
                    ?>
                </div>

                <div class="form-group">
                    <label for="newEmail">New Email:</label>
                    <input name="newEmail" type="email" class="form-control" id="newEmail" value="<?php echo $row['email']; ?>">
                    <?php
                    if(isset($errors["newEmail"])){
                        echo '<div class="error-message">' . $errors["newEmail"] . '</div>';
                    }
                    ?>
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Date of Birth:</label>
                    <input name="date_of_birth" type="date" class="form-control" id="date_of_birth" value="<?php echo $row['date_of_birth']; ?>">
                    <?php
                    if(isset($errors["date_of_birth"])){
                        echo '<div class="error-message">' . $errors["date_of_birth"] . '</div>';
                    }
                    ?>
                </div>

                <div class="form-group">
                    <label>Gender:</label>
                    <div class="form-check">
                        <input name="gender" type="radio" class="form-check-input" value="male" id="male" <?php echo ($row['gender'] == 'male') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check">
                        <input name="gender" type="radio" class="form-check-input" value="female" id="female" <?php echo ($row['gender'] == 'female') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                    <div class="form-check">
                        <input name="gender" type="radio" class="form-check-input" value="other" id="other" <?php echo ($row['gender'] == 'other') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="other">Others</label>
                    </div>
                    <?php
                    if(isset($errors["gender"])){
                        echo '<div class="error-message">' . $errors["newEmail"] . '</div>';
                    }
                    ?>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-warning">Update Profile</button>
                </div>
            </form>
        </div>
    </center>
</body>
</html>
