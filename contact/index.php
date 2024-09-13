<?php
session_start();

$nameError = $emailError = $messageError = "";
$name = $email = $message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Validate name
    if (empty($_POST['name'])) {
        $nameError = "Name is required";
    } else {
        $name = test_input($_POST['name']);
        //Check if name contains only letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameError = "Only letters and white space allowed";
        }
    }

    if (empty($_POST['email'])) {
        $emailError = "Email is required";
    } else {
        $email = test_input($_POST['email']);
        //Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format";
        }
    }

    if (empty($_POST['message'])) {
        $messageError = "Message is required";
    } else {
        $message = test_input($_POST['message']);
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="contact.css">
    <title>Contact Us - Mondstadt Market</title>
</head>

<body>
    <?php include("../includes/header.php"); ?>
    <main class="help-page">
        <div class="container">
            <div class="left-side">
                <h2>Call Us</h2>
                <p>+333 1 555 8800</p>
                <h2>Location</h2>
                <p>22, Jln 3/27F Seksyen 2, Wangsa Maju, 53300 Kuala Lumpur </p>
            </div>

            <div class="right-side">
                <h1>Contact Us</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="contactForm">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name">
                    <div class="error"><?php echo $nameError; ?></div><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                    <div class="error"><?php echo $emailError; ?></div><br>
                    <label for="message">Message:</label>
                    <textarea rows="10" cols="20" id="message" name="message"></textarea>
                    <div class="error"><?php echo $messageError; ?></div><br><br>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </main>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                    pageLanguage: 'en'
                },
                'google_translate_element'
            );
        }
    </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <?php include("../includes/footer.php"); ?>
</body>

</html>
