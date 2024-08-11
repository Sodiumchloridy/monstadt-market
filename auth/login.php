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

    <?php
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
            $stmt = mysqli_prepare($conn, "SELECT u_password FROM users WHERE u_username=?");
            mysqli_stmt_bind_param($stmt, "s", $name);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $pass);
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
            // TODO: password hashing -> if(password_verify($_POST['password'], $pass)) {
            if($pass === $_POST['password']) {
                $validPass = true;
            } else {
                $passErr = "Invalid password";
            }
        }
        mysqli_close($conn);
    }

    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="loginForm">
        <h2>Log In</h2>
        <div id="nameInput">
            <input type="text" id="name" name="name" placeholder="Username">
            <div class="error"> <?php echo $nameErr; ?> </div>
        </div>
        <br>
        <div id="passInput">
            <input type="password" name="password" id="password" placeholder="Password">
            <div class="error"> <?php echo $passErr; ?> </div>
        </div>
        <br>
        <input type="submit" value="Submit" id="submit-button">
    </form>
</body>

</html>