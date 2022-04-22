<?php
    require_once("includes/header.php"); 
    $account = new Account($conn);
    if(isset($_POST['submitBtn'])){

        $firstName = FormSanitizer::sanitizeInput($_POST['firstName']);
        $lastName = FormSanitizer::sanitizeInput($_POST['lastName']);
        $username = FormSanitizer::sanitizeUsername($_POST['username']);
        $email = FormSanitizer::sanitizeEmail($_POST['email']);
        $email2 = FormSanitizer::sanitizeEmail($_POST['cEmail']);
        $password = FormSanitizer::sanitizePassword($_POST['password']);
        $password2 = FormSanitizer::sanitizePassword($_POST['cpassword']);
        $success = $account->register($email,$email2,$username,$firstName,$lastName,$password,$password2);
        if($success){
            header('Location:login.php');
            die();
        }
        
    }
    function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }
?>
    <main class="register__main">
        <div class="form__section">
            <form class="form" method="post">
                <div class="logo">
                    <img src="assets/images/websitelogo.png" alt="logo" class="logo__image">
                </div>
                <h2>Sign Up</h2>
                <p class="form__text">To continue to WeWatch</p>
                <div class="input__container">
                    <input type="text" id="firstName" name="firstName" placeholder="First name" required value="<?php getInputValue("firstName") ?>">
                    <label for="firstName">First name</label>
                    <?php
                        echo  '<div class="error">'.$account->getErrorMessage(Constant::$firstNameError)."</div>";
                    ?>
                </div>
                <div class="input__container">
                    <input type="text" id="lastName" name="lastName" placeholder="Last name" required value="<?php getInputValue("lastName") ?>">
                    <label for="lastName">Last name</label>
                       <?php
                        echo  '<div class="error">'.$account->getErrorMessage(Constant::$lastNameError)."</div>";
                    ?>
                </div>
                <div class="input__container">
                    <input type="text" id="username" name="username" placeholder="username" required value="<?php getInputValue("username") ?>">
                    <label for="username">username</label>
                       <?php
                        echo  '<span class="error">'.$account->getErrorMessage(Constant::$usernameError)."</span>";
                        echo  '<span class="error">'.$account->getErrorMessage(Constant::$usernameTakenError)."</span>";
                    ?>
                </div>
                <div class="input__container">
                    <input type="text" id="email" name="email" placeholder="Email" required value="<?php getInputValue("email") ?>">
                    <label for="email">Email</label>
                       <?php
                            echo  '<span class="error">'.$account->getErrorMessage(Constant::$emailMatchError)."</span>";
                            echo  '<span class="error">'.$account->getErrorMessage(Constant::$emailError)."</span>";
                            echo  '<span class="error">'.$account->getErrorMessage(Constant::$emailTakenError)."</span>";
                    ?>
                </div>
                <div class="input__container">
                    <input type="text" id="cEmail" name="cEmail" placeholder="Confirm email" required value="<?php getInputValue("cEmail") ?>">
                    <label for="cEmail">Confirm email</label>
               
                </div>
                <div class="input__container">
                    <input type="password" id="pw" class="password" placeholder="Password"  name="password" required min="8">
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
    <script>
        $(".topBar").addClass("scrolled")
      
    </script>
</body>
</html>