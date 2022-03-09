<?php 
    require_once("includes/header.php"); 
    $account = new Account($conn);
    if(isset($_POST['submitBtn'])){
        $username =  FormSanitizer::sanitizeUsername($_POST['uemail']);
        $password =  FormSanitizer::sanitizePassword($_POST['password']);
        $suceess = $account->login($username, $password);
        if($suceess){
            $_SESSION["userLoggedIn"]=$username;
            if($_SESSION['role'] === 'admin') {
                header("Location:admin/index.php");
                die();
            }
            header("Location:index.php");
            die();
        }
    }
    function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }

?>
   

    <main class="register__main login">
        <div class="form__section">
            <form class="form" method="post">
                <div class="logo">
                    <img src="assets/images/websitelogo.png" alt="logo" class="logo__image">
                </div>
                <h2>Login</h2>
                <p class="form__text">To continue to WeWatch</p>
                <?php 

                    echo '<span class="error">' . $account->getErrorMessage(Constant::$loginError) . '</span>';
                    echo '<span class="error">' . $account->getErrorMessage(Constant::$banError) . '</span>';
                
                ?>
                <div class="input__container">
                    <input type="text" id="username" name="uemail" placeholder="username or email" required value="<?php getInputValue("uemail") ?>">
                    <label for="username">username</label>
                </div>
                <div class="input__container">
                    <input type="password" id="pw" class="password" placeholder="Password"  name="password" required min="8">
                    <label for="pw">Password</label>
                </div>
                <input type="submit" class="submit-btn" value="Submit" name="submitBtn">
                <a href="register.php" class="login__link">Have no account ? sign up here !</a>
                <a href="forgot-password.php" class="login__link">Forgot Password ? click here !</a>

            </form>
        </div>
    </main>
    <script>
        $(".topBar").addClass("scrolled")
      
    </script>

</body>
</html>