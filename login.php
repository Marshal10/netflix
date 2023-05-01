<?php
require_once("includes/classes/Formsanitization.php");
require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");


$account = new Account($con);


if (isset($_POST["submitButton"])) {

    $userName = Formsanitization::sanitizeUserName($_POST["userName"]);
    $password = Formsanitization::sanitizePassword(($_POST["password"]));

    $success = $account->login($userName, $password);

    if ($success) {
        $_SESSION["userLoggedIn"] = $userName;
        header("Location:index.php");
    }


}
function getInputText($name){
    if(isset($_POST[$name])){
        echo $_POST[$name];
    }

}
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/style.css">
    </link>
    <title>Netflix</title>
</head>

<body>
    <div class="signup-container">

        <div class="column">
            <div class="logo">
                <a href="index.php"><img src="assets/styles/imgs/netflix.png" alt="Netflix Logo"></img></a>
            </div>
            <div class="signup-heading">
                <h3>Sign In</h3>
            </div>
            <form method="POST">
                <?php echo $account->getError(Constants::$loginFail) ?>
                <input type="text" placeholder="Username" name="userName" value="<?php getInputText('userName');?>" required>

                <input type="password" placeholder="Password" name="password" required>

                <input type="submit" name="submitButton" value="Sign In">
            </form>

            <a href="register.php" class="signInMessage">Don't have an account? Sign up now!</a>
        </div>
    </div>
</body>

</html>