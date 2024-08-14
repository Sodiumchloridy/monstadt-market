<?php

$name = $pass = $email = $phone = $address = $message = $result = "";
$nameErr = $passErr = $emailErr = $phoneErr = $unitErr = $streetErr = $poskodErr = $stateErr = "";
$addressErr = [];

// connect to server using config script
include ("../config/config.php");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['name'])) {
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
    if(!isset($_POST['password'])) {
        $passErr = "Password is required";
    } else {
        $pass = test_input($_POST['password']);
    }
    if(!isset($_POST['email'])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST['email']);
    }
    if(!isset($_POST['phone'])) {
        $phoneErr = "Phone is required";
    } else {
        $phone = test_input($_POST['phone']);
    }
    if(!isset($_POST['unit'])) {
        $unitErr = "Unit is required";
        $addressErr[] = $unitErr;
    }
    if(!isset($_POST['street'])) {
        $streetErr = "Street is required";
        $addressErr[] = $streetErr;
    }
    if(!isset($_POST['poskod'])) {
        $poskodErr = "Poskod is required";
        $addressErr[] = $poskodErr;
    }
    if(!isset($_POST['state'])) {
        $stateErr = "State is required";
        $addressErr[] = $stateErr;
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

        

        $stmt = mysqli_prepare($conn, "INSERT INTO users (u_username, u_password, u_email, u_address, u_phone) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $name, $hashedPass, $email, $address, $phone);

        
        if(mysqli_stmt_execute($stmt)) {
            $message = "Record inserted successfully";
        } else {
            $message = "Error inserting record: " . mysqli_error($conn);
        }

        // closing statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

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
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="signupForm">
        <h2>Sign Up</h2>
        <?php echo $message;?>
        <table>
            <tr>
                <td>
                    <!-- Name input -->
                    <input type="text" name="name" placeholder="Username">
                    <div class="error"><?php echo $nameErr;?></div>
                    
                </td>
                <td>
                    <!-- Password input -->
                    <input type="password" name="password" id="password" placeholder="Password">
                    <div class="error"><?php echo $passErr?></div>
                </td>
            </tr>
            <tr>
                <td>
                    <!-- Email input -->
                    <input type="email" name="email" placeholder="Email">
                    <div class="error"><?php echo $emailErr?></div>
                </td>
                <td>
                    <!-- Telephone input -->
                    <input type="tel" name="phone" placeholder="Phone">
                    <div class="error"><?php echo $phoneErr?></div>
                </td>
            </tr>
            <!-- Address input -->
            <tr>
                <td>
                    <input type="text" name="unit" placeholder="Unit">
                    <div class="error"><?php echo $unitErr?></div>
                </td>
                <td>
                    <input type="text" name="street" placeholder="Street">
                    <div class="error"><?php echo $streetErr?></div>
                </td>
                <td>
                    <input type="text" name="poskod" placeholder="Poskod">
                    <div class="error"><?php echo $poskodErr?></div>
                </td>
            </tr>
            <tr>
                <td>
                    <select name="state" required>
                        <option value="" disabled selected>Select State</option>
                        <option value="Johor">Johor</option>
                        <option value="Kedah">Kedah</option>
                        <option value="Kelantan">Kelantan</option>
                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                        <option value="Labuan">Labuan</option>
                        <option value="Melaka">Melaka</option>
                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                        <option value="Pahang">Pahang</option>
                        <option value="Penang">Penang</option>
                        <option value="Perak">Perak</option>
                        <option value="Perlis">Perlis</option>
                        <option value="Putrajaya">Putrajaya</option>
                        <option value="Sabah">Sabah</option>
                        <option value="Sarawak">Sarawak</option>
                        <option value="Selangor">Selangor</option>
                        <option value="Terengganu">Terengganu</option>
                    </select>
                    <div class="error"><?php echo $stateErr?></div>
                </td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Sign Up" id="submit-button">
    </form>
</body>
</html>