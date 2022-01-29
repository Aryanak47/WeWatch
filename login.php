<?php 
    require_once('includes/classes/config.php');
    require_once('includes/classes/FormSanitizer.php');
    require_once('includes/classes/Constant.php');
    require_once('includes/classes/Account.php');
    $account = new Account($conn);
    if(isset($_POST['submitBtn'])){
        $username =  FormSanitizer::sanitizeUsername($_POST['uemail']);
        $password =  FormSanitizer::sanitizePassword($_POST['password']);
        $suceess = $account->login($username, $password);
        if($suceess){
            $_SESSION["login"]='yes';
            if($_SESSION['role'] === 'admin') {
                header("Location:admin/index.php");
                die();
            }
            header("Location:index.php");
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
    <title>Login</title>
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
            <form class="form"  t">
                <div class="logo">
                    <img src="assets/images/websitelogo.png" alt="logo" class="logo__image">
                </div>
                <h2>Login</h2>
                <p class="form__text">To continue to WeWatch</p>
                <?php 
                    echo '<span class="error">' . $account->getErrorMessage(Constant::$loginError) . '</span>';
                
                ?>
                <div class="input__container">
                    <input type="text" id="username" name="uemail" placeholder="username or email" required>
                    <label for="username">username or email</label>
                </div>
                <div class="input__container">
                    <input type="password" id="pw" class="password" placeholder="Password" name="password" required min="8">
                    <label for="pw">Password</label>
                </div>
                <input type="submit" class="submit-btn" value="Submit" name="submitBtn">
                <a href="register.php" class="login__link">Have no account ? sign up here !</a>

            </form>
        </div>
    </main>

</body>
</html>