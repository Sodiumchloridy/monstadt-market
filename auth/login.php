<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$name = isset($_COOKIE['username']) ? $_COOKIE['username'] : "";
$pass = isset($_COOKIE['password']) ? $_COOKIE['password'] : "";

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
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE BINARY u_username=?");
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userId, $username, $pass, $email, $address, $phone, $profilePic, $profilePicType, $regDate);
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
        $_SESSION['email'] = $email;
        $_SESSION['address'] = $address;
        $_SESSION['phone'] = $phone;
        $_SESSION['profile_pic'] = $profilePic;
        $_SESSION['profile_pic_type'] = $profilePicType;
        $_SESSION['reg_date'] = $regDate;

        // Set cookies for username and password only if the user accepted the cookie policy with expiry time of 30days
        if (isset($_COOKIE['cookie_consent']) && $_COOKIE['cookie_consent'] === "yes") {
            setcookie("username", $name, time() + (30 * 24 * 60 * 60), "/");
            setcookie("password", $_POST['password'], time() + (30 * 24 * 60 * 60), "/");
        }

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
    <link rel="stylesheet" href="cookies.css">
</head>

<body>
    <?php include("../includes/header.php"); ?>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="loginForm">
            <h2>Log In</h2>
            <!-- Name input -->
            <input type="text" name="name" placeholder="Username" value="<?php echo $name; ?>">
            <div class="error"> <?php echo $nameErr; ?> </div>
            <br>
            <!-- Password input -->
            <input type="password" name="password" placeholder="Password" value="<?php echo $pass; ?>">
            <div class="error"> <?php echo $passErr; ?> </div>
            <br>
            <input type="submit" value="Login" id="submit-button">
            <p>Don't have an account? <a href="signup.php">Register</a></p>
            <image src="../default_images/anya-peek.png" alt="anya peeking" id="anya">
        </form>
    </main>
    <!-- Cookie Consent Banner -->
    <div id="cookie-consent-banner">
        <p>This website uses cookies to improve your experience. Do you accept cookies?</p>
        <button id="accept-cookies-btn" onclick="acceptCookie()">Accept</button>
        <button id="decline-cookies-btn" onclick="declineCookie()">
            <i class="fa-solid fa-x"></i>
            z</button>
    </div>

    <script>
        // Show the cookie consent banner if the user hasn't made a choice yet
        if (!document.cookie.includes("cookie_consent")) {
            document.getElementById('cookie-consent-banner').style.display = 'block';
        }

        function acceptCookie() {
            document.cookie = "cookie_consent=yes; path=/; max-age=" + 30 * 24 * 60 * 60; // Set consent cookie for 30 days
            document.getElementById('cookie-consent-banner').style.display = 'none';
        }

        function declineCookie() {
            document.cookie = "cookie_consent=no; path=/; max-age=" + 30 * 24 * 60 * 60;
            document.getElementById('cookie-consent-banner').style.display = 'none';
        }
    </script>

    <?php include("../includes/footer.php"); ?>
</body>

</html>