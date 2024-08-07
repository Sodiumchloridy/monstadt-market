<?php 
    $name = $pass = "";
    $nameErr = $passErr = "";

    // TODO: load the data from db and store inside a result set

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // validate name
        if(empty($_POST['name'])) {
            $nameErr = 'Name is required';
        } // TODO: validate name

    }

?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">

    <label for="name">Name</label>
    <input type="text" id="name" name="name"> <span class="error"> <?php echo $nameErr; ?> </span>

    <label for="password">Password</label>
    <input type="password" name="password" id="password"> <span class="error"> <?php echo $passErr; ?> </span>

    <input type="submit" value="Submit">
</form>