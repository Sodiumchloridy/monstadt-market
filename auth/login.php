<?php 
    $name = $pass = "";
    $nameErr = $passErr = "";
    $validName = $validPass = false;

    // TODO: load the data from db and store inside a result set
    include '../config/config.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $sql = "SELECT * FROM Users";
        $result = mysqli_query($conn, $sql);

        // check if name is empty
        if(empty($_POST['name'])) {
            $nameErr = 'Name is required';

            // check is there any rows
        } else if(mysqli_num_rows($result) > 0) {
            $name = $_POST['name'];

            // loop through each row
            while($row = mysqli_fetch_assoc($result)) {
                if($name === $row['u_username']) {
                    $validName = true;
                }
            }
            if($validName === false) {
                $nameErr = "Invalid name";
            }
        }

        // check if password is empty
        if(empty($_POST['password'])) {
            $passErr = 'Password is required';

            // check is there any rows
        } else if(mysqli_num_rows($result) > 0) {
            $pass = $_POST['password'];
            // loop through each row
            while($row = mysqli_fetch_assoc($result)) {
                if($pass === $row['u_password']) {
                    $validPass = true;
                }
            }
            if($validPass === false) {
                $passErr = "Invalid password";
            }
        }

    }

?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">

    <label for="name">Name</label>
    <input type="text" id="name" name="name"> <span class="error"> <?php echo $nameErr; ?> </span>

    <label for="password">Password</label>
    <input type="password" name="password" id="password"> <span class="error"> <?php echo $passErr; ?> </span>

    <input type="submit" value="Submit">
</form>