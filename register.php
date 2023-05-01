<?php
require_once("includes/classes/Formsanitization.php");
require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");


$account = new Account($con);


if (isset($_POST["submitButton"])) {
    $firstName = Formsanitization::sanitizeFirstName($_POST["firstName"]);
    $lastName = Formsanitization::sanitizeLastName($_POST["lastName"]);
    $userName = Formsanitization::sanitizeUserName($_POST["userName"]);
    $email = Formsanitization::sanitizeEmail($_POST["email"]);
    $email2 = Formsanitization::sanitizeEmail($_POST["confirmEmail"]);
    $password = Formsanitization::sanitizePassword(($_POST["password"]));
    $password2 = Formsanitization::sanitizePassword(($_POST["confirmPassword"]));

    $success=$account->register($firstName,$lastName,$userName,$email,$email2,$password,$password2);

    if($success){
        $_SESSION["userLoggedIn"]=$userName;
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
                <h3>Sign Up</h3>
            </div>
            <form method="POST">
                <?php echo $account->getError(Constants::$firstNameCharachters) ?>
                <input type="text" placeholder="First Name" name="firstName" value="<?php getInputText('firstName');?>" required>

                <?php echo $account->getError(Constants::$lastNameCharachters) ?>
                <input type="text" placeholder="Last Name" name="lastName" value="<?php getInputText('lastName');?>" required>

                <?php echo $account->getError(Constants::$userNameCharachters) ?>
                <?php echo $account->getError(Constants::$userNameTaken) ?>
                <input type="text" placeholder="Username" name="userName" value="<?php getInputText('userName');?>" required>

                <?php echo $account->getError(Constants::$emailDontMatch) ?>
                <?php echo $account->getError(Constants::$invalidEmail) ?>
                <?php echo $account->getError(Constants::$emailTaken) ?>
                <input type="email" placeholder="Email" name="email" value="<?php getInputText('email');?>" required>

                <input type="email" placeholder="Confirm email" name="confirmEmail" value="<?php getInputText('confirmEmail');?>" required>
                
                <?php echo $account->getError(Constants::$passwordDontMatch) ?>
                <?php echo $account->getError(Constants::$passwordCharachters) ?>
                <input type="password" placeholder="Password" name="password" required>

                <input type="password" placeholder="Confirm Password" name="confirmPassword" required>

                <input type="submit" name="submitButton" value="Submit">
            </form>

            <a href="login.php" class="signInMessage">Already have an account? Sign in here!</a>
        </div>
    </div>
</body>

</html>