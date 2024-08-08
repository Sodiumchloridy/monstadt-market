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

        $sql = "SELECT u_username, u_password FROM Users";
        $result = mysqli_query($conn, $sql);

        // check if name is empty
        if (empty($_POST['name'])) {
            $nameErr = 'Name is required';

            // check is there any rows
        } else if (mysqli_num_rows($result) > 0) {
            $name = $_POST['name'];

            // loop through each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo $row['u_username'] . $row['u_password'] . "<br>"; //TODO: fix the invalid password problem even if its entered correctly
                if ($name === $row['u_username']) {
                    $validName = true;
                }
            }
            if ($validName === false) {
                $nameErr = "Invalid name";
            }
        }

        // check if password is empty
        if (empty($_POST['password'])) {
            $passErr = 'Password is required';

            // check is there any rows
        } else if (mysqli_num_rows($result) > 0) {
            $pass = $_POST['password'];

            // loop through each row
            while ($row = mysqli_fetch_assoc($result)) {
                if ($pass === $row['u_password']) {
                    $validPass = true;
                }
            }
            if ($validPass === false) {
                $passErr = "Invalid password";
            }
        }

        mysqli_free_result($result);
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