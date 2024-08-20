<?php
session_start();

if(isset($_SESSION['user_id'])){
    die("You already logged in");
}

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
        $stmt = mysqli_prepare($conn, "SELECT u_id, u_password, u_profile_pic, u_profile_pic_type FROM users WHERE u_username=?");
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userId, $pass, $profilePic, $profilePicType);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($pass) {
            $validName = true;
        } else {
            $nameErr = "Invalid name";
        }
    }

    // check if password is empty
    if (empty($_POST['password'])) {
        $passErr = 'Password is required';

        // check is there any rows
    } else if ($validName) {
        if (password_verify($_POST['password'], $pass)) {
            $validPass = true;
        } else {
            $passErr = "Invalid password";
        }
    }

    mysqli_close($conn);
    if (empty($nameErr) && empty($passErr) && $validName && $validPass) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $name;
        $_SESSION['profile_pic'] = $profilePic;
        $_SESSION['profile_pic_type'] = $profilePicType;

        $redirectUrl = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : '../index.php';
        unset($_SESSION['redirect_after_login']);
        header("Location: $redirectUrl");
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
    <link rel="stylesheet" href="../styles/error.css">
    <link rel="stylesheet" href="../styles/loginForm.css">
</head>

<body>
    <?php include("../includes/header.php"); ?>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="loginForm">
            <h2>Log In</h2>
            <!-- Name input -->
            <input type="text" name="name" placeholder="Username">
            <div class="error"> <?php echo $nameErr; ?> </div>
            <br>
            <!-- Password input -->
            <input type="password" name="password" placeholder="Password">
            <div class="error"> <?php echo $passErr; ?> </div>
            <br>
            <input type="submit" value="Login" id="submit-button">
            <p>Don't have an account? <a href="signup.php">Register</a></p>
            <image src="../default_images/anya-peek.png" alt="anya peeking" id="anya">
        </form>
    </main>
    <?php include("../includes/footer.php"); ?>
</body>

</html>
