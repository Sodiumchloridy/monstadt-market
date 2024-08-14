<?php
    session_start();

    $name = $pass = "";
    $nameErr = $passErr = "";
    $validName = $validPass = false;

    // connecting to server using config.php script
    include '../config/config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // check if name is empty
        if (empty($_POST['name'])) {
            $nameErr = 'Name is required';

            // check is there any rows
        } else {
            $name = $_POST['name'];

            // Check if the name exist in database
            $stmt = mysqli_prepare($conn, "SELECT u_password, u_profile_pic, u_profile_pic_type FROM users WHERE u_username=?");
            mysqli_stmt_bind_param($stmt, "s", $name);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $pass, $profilePic, $profilePicType);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if($pass) {
                $validName = true;
            } else {
                $nameErr = "Invalid name";
            }
        }

        // check if password is empty
        if (empty($_POST['password'])) {
            $passErr = 'Password is required';

            // check is there any rows
        } else if($validName){
            // TODO: password hashing -> 
            // if($pass === $_POST['password']) {
            if(password_verify($_POST['password'], $pass)) {
                $validPass = true;
            } else {
                $passErr = "Invalid password";
            }
        }

        mysqli_close($conn);
        if(empty($nameErr) && empty($passErr) && $validName && $validPass) {
            $_SESSION['username'] = $name;
            $_SESSION['profile_pic'] = $profilePic;
            $_SESSION['profile_pic_type'] = $profilePicType;

            header("Location: ../index.php");
            exit();
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/error.css">
    <link rel="stylesheet" href="../styles/loginForm.css">
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="loginForm">
        <h2>Log In</h2>
        <!-- Name input -->
        <div>
            <input type="text" name="name" placeholder="Username">
            <div class="error"> <?php echo $nameErr; ?> </div>
        </div>
        <br>
        <!-- Password input -->
        <div>
            <input type="password" name="password" placeholder="Password">
            <div class="error"> <?php echo $passErr; ?> </div>
        </div>
        <br>
        <input type="submit" value="Login" id="submit-button">
    </form>
</body>

</html>