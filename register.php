<?php
    require_once('includes/classes/Config.php');
    require_once('includes/classes/FormSanitizer.php');
    require_once('includes/classes/Constant.php');
    require_once('includes/classes/Account.php');
    $account = new Account($conn);
    if(isset($_POST['submitBtn'])){

        $firstName = FormSanitizer::sanitizeInput($_POST['firstName']);
        $lastName = FormSanitizer::sanitizeInput($_POST['lastName']);
        $username = FormSanitizer::sanitizeUsername($_POST['username']);
        $email = FormSanitizer::sanitizeEmail($_POST['email']);
        $email2 = FormSanitizer::sanitizeEmail($_POST['cEmail']);
        $password = FormSanitizer::sanitizePassword($_POST['password']);
        $password2 = FormSanitizer::sanitizePassword($_POST['cpassword']);
        $success->register($email,$email2,$username,$firstName,$lastName,$password,$password2);
        if($success){
            header('Location:login.php');
            die();
        }
        
    }







?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header id="header">
        <div class="logo">
            <img src="assets/images/websitelogo.png" alt="logo" class="logo__image">
        </div>
        <nav class="nav">
            <ul class="nav__lists">
                <li class="nav__list"><a href="http://" class="nav__link active">Home</a></li>
                <li class="nav__list"><a href="http://" class="nav__link">TV shows</a></li>
                <li class="nav__list"><a href="http://" class="nav__link">Movies</a></li>
                <li class="nav__list"><a href="http://" class="nav__link">Recently Added</a></li>
            </ul>
        </nav>
        <div class="nav__left">
           <span class="nav__left-item">
               <svg class="icon icon-user"><use xlink:href="assets/images/sprite.svg#icon-user"></use></svg>
           </span>
           <span class="nav__left-item">
               <svg class="icon icon-search"><use xlink:href="assets/images/sprite.svg#icon-search"></use></svg>
           </span>
        </div>

    </header>
    <main class="register__main">
        <div class="form__section">
            <form class="form" method="post">
                <div class="logo">
                    <img src="assets/images/websitelogo.png" alt="logo" class="logo__image">
                </div>
                <h2>Sign Up</h2>
                <p class="form__text">To continue to WeWatch</p>
                <div class="input__container">
                    <input type="text" id="firstName" name="firstName" placeholder="First name" required>
                    <label for="firstName">First name</label>
                    <?php
                        echo  '<div class="error">'.$account->getErrorMessage(Constant::$firstNameError)."</div>";
                    ?>
                </div>
                <div class="input__container">
                    <input type="text" id="lastName" name="lastName" placeholder="Last name" required>
                    <label for="lastName">Last name</label>
                       <?php
                        echo  '<div class="error">'.$account->getErrorMessage(Constant::$lastNameError)."</div>";
                    ?>
                </div>
                <div class="input__container">
                    <input type="text" id="username" name="username" placeholder="username" required>
                    <label for="username">username</label>
                       <?php
                        echo  '<span class="error">'.$account->getErrorMessage(Constant::$usernameError)."</span>";
                        echo  '<span class="error">'.$account->getErrorMessage(Constant::$usernameTakenError)."</span>";
                    ?>
                </div>
                <div class="input__container">
                    <input type="text" id="email" name="email" placeholder="Email" required>
                    <label for="email">Email</label>
                       <?php
                            echo  '<span class="error">'.$account->getErrorMessage(Constant::$emailMatchError)."</span>";
                            echo  '<span class="error">'.$account->getErrorMessage(Constant::$emailError)."</span>";
                            echo  '<span class="error">'.$account->getErrorMessage(Constant::$emailTakenError)."</span>";
                    ?>
                </div>
                <div class="input__container">
                    <input type="text" id="cEmail" name="cEmail" placeholder="Confirm email" required>
                    <label for="cEmail">Confirm email</label>
               
                </div>
                <div class="input__container">
                    <input type="password" id="pw" class="password" placeholder="Password" name="password" required min="8">
                    <label for="pw">Password</label>
                       <?php
                        echo  '<div class="error">'.$account->getErrorMessage(Constant::$passwordMatchError)."</div>";
                        echo  '<div class="error">'.$account->getErrorMessage(Constant::$passwordError)."</div>";
                    ?>
                </div>
                <div class="input__container">
                    <input type="password" id="pw" class="cPassword" name="cpassword" placeholder="Confirm Password" required>
                    <label for="pw">Confirm Password</label>
                </div>
                <input type="submit" class="submit-btn" value="Submit" name="submitBtn">
                <a href="login.php" class="login__link">Already have an account ? sign in here !</a>

            </form>
        </div>
    </main>

</body>
</html>