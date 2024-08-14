<?php
session_start();

$name = $pass = $email = $phone = $address = $unit = $street = $poskod = $state = $message = $result = "";
$nameErr = $passErr = $emailErr = $phoneErr = $unitErr = $streetErr = $poskodErr = $stateErr = "";
$addressErr = [];

// connect to server using config script
include ("../config/config.php");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(empty($_POST['name'])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST['name']);

        // Check if the name exist in database
        $stmt = mysqli_prepare($conn, "SELECT u_id FROM users WHERE u_username=?");
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if($result) {
            $nameErr = "Duplicated name. Please try another username.";
        }
    }
    if(empty($_POST['password'])) {
        $passErr = "Password is required";
    } else {
        $pass = test_input($_POST['password']);
    }
    if(empty($_POST['email'])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST['email']);
    }
    if(empty($_POST['phone'])) {
        $phoneErr = "Phone is required";
    } else {
        $phone = test_input($_POST['phone']);
    }
    if(empty($_POST['unit'])) {
        $unitErr = "Unit is required";
        $addressErr[] = $unitErr;
    } else {
        $unit = test_input($_POST['unit']);
    }
    if(empty($_POST['street'])) {
        $streetErr = "Street is required";
        $addressErr[] = $streetErr;
    } else {
        $street = test_input($_POST['street']);
    }
    if(empty($_POST['poskod'])) {
        $poskodErr = "Poskod is required";
        $addressErr[] = $poskodErr;
    } else {
        $poskod = test_input($_POST['poskod']);
    }
    if(empty($_POST['state'])) {
        $stateErr = "State is required";
        $addressErr[] = $stateErr;
    } else {
        $state = test_input($_POST['state']);
    }
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imgTmpPath = $_FILES['image']['tmp_name'];
        $imgData = file_get_contents($imgTmpPath);
        $imgType = $_FILES['image']['type'];
    } else {
        // use default picture if no file is uploaded
        $imgData = file_get_contents("../default_images/default_profile.jpg");
        $imgType = mime_content_type("../default_images/default_profile.jpg");
    }

    if(count($addressErr) === 0 && empty($nameErr) && empty($passErr) && empty($emailErr) && empty($phoneErr)) {
        
        $name = test_input($_POST['name']);
        $email = test_input($_POST['email']);
        $phone = test_input($_POST['phone']);
        // hashing password for security purposes
        $pass = test_input($_POST['password']);
        $hashedPass = password_hash($pass, PASSWORD_BCRYPT);
        
        $unit = test_input($_POST['unit']);
        $street = test_input($_POST['street']);
        $poskod = test_input($_POST['poskod']);
        $state = test_input($_POST['state']);
        $address = "$unit $street $poskod $state";

        $stmt = mysqli_prepare($conn, "INSERT INTO users (u_username, u_password, u_email, u_address, u_phone, u_profile_pic, u_profile_pic_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssss", $name, $hashedPass, $email, $address, $phone, $imgData, $imgType);

    
        if(mysqli_stmt_execute($stmt)) {
            $message = "Record inserted successfully";
        } else {
            $message = "Error inserting record: " . mysqli_error($conn);
        }
        

        // closing statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: login.php");
        exit();

    }

}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data" id="signupForm">
        <h2>Sign Up</h2>
        <?php echo $message;?>
        <table>
            <tr>
                <td>
                    <!-- Name input -->
                    <input type="text" name="name" placeholder="Username" value="<?php echo htmlspecialchars($name)?>">
                    <div class="error"><?php echo $nameErr;?></div>
                    
                </td>
                <td>
                    <!-- Password input -->
                    <input type="password" name="password" id="password" placeholder="Password" value="<?php echo htmlspecialchars($pass)?>">
                    <div class="error"><?php echo $passErr?></div>
                </td>
            </tr>
            <tr>
                <td>
                    <!-- Email input -->
                    <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email)?>">
                    <div class="error"><?php echo $emailErr?></div>
                </td>
                <td>
                    <!-- Telephone input -->
                    <input type="tel" name="phone" placeholder="Phone" value="<?php echo htmlspecialchars($phone)?>">
                    <div class="error"><?php echo $phoneErr?></div>
                </td>
            </tr>
            <!-- Address input -->
            <tr>
                <td>
                    <input type="text" name="unit" placeholder="Unit" value="<?php echo htmlspecialchars($unit)?>">
                    <div class="error"><?php echo $unitErr?></div>
                </td>
                <td>
                    <input type="text" name="street" placeholder="Street" value="<?php echo htmlspecialchars($street)?>">
                    <div class="error"><?php echo $streetErr?></div>
                </td>
                <td>
                    <input type="text" name="poskod" placeholder="Poskod" value="<?php echo htmlspecialchars($poskod)?>">
                    <div class="error"><?php echo $poskodErr?></div>
                </td>
            </tr>
            <tr>
                <td>
                    <select name="state" required>
                        <option value="" disabled <?php if ($state == "") echo 'selected'; ?> >Select State</option>
                        <option value="Johor" <?php if ($state == "Johor") echo 'selected'; ?>>Johor</option>
                        <option value="Kedah" <?php if ($state == "Kedah") echo 'selected'; ?>>Kedah</option>
                        <option value="Kelantan" <?php if ($state == "Kelantan") echo 'selected'; ?>>Kelantan</option>
                        <option value="Kuala Lumpur" <?php if ($state == "Kuala Lumpur") echo 'selected'; ?>>Kuala Lumpur</option>
                        <option value="Labuan" <?php if ($state == "Labuan") echo 'selected'; ?>>Labuan</option>
                        <option value="Melaka" <?php if ($state == "Melaka") echo 'selected'; ?>>Melaka</option>
                        <option value="Negeri Sembilan" <?php if ($state == "Negeri Sembilan") echo 'selected'; ?>>Negeri Sembilan</option>
                        <option value="Pahang" <?php if ($state == "Pahang") echo 'selected'; ?>>Pahang</option>
                        <option value="Penang" <?php if ($state == "Penang") echo 'selected'; ?>>Penang</option>
                        <option value="Perak" <?php if ($state == "Perak") echo 'selected'; ?>>Perak</option>
                        <option value="Perlis" <?php if ($state == "Perlis") echo 'selected'; ?>>Perlis</option>
                        <option value="Putrajaya" <?php if ($state == "Putrajaya") echo 'selected'; ?>>Putrajaya</option>
                        <option value="Sabah" <?php if ($state == "Sabah") echo 'selected'; ?>>Sabah</option>
                        <option value="Sarawak" <?php if ($state == "Sarawak") echo 'selected'; ?>>Sarawak</option>
                        <option value="Selangor" <?php if ($state == "Selangor") echo 'selected'; ?>>Selangor</option>
                        <option value="Terengganu" <?php if ($state == "Terengganu") echo 'selected'; ?>>Terengganu</option>
                    </select>
                    <div class="error"><?php echo $stateErr?></div>
                </td>
            </tr>
            <tr>
                <td colspan = "3">
                    <input type="file" name="image" accept="image/*">
                </td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Sign Up" id="submit-button">
    </form>
</body>
</html>