<?php 
     require_once("includes/config.php");
     $errors = array();
    //if user click continue button in forgot password form
    if(isset($_POST['check-email'])){
        $email = $_POST['email'];
        $query = $conn->prepare("SELECT * FROM users where email=:email");
        $query->bindParam(':email',$email);
        $query->execute();
        if($query->rowCount() > 0){
            $code = rand(999999, 111111);
            $query = $conn->prepare("UPDATE users SET code = $code WHERE email = '$email'");
            $query->execute();
            if($query->rowCount() > 0){
                $subject = "Password Reset Code";
                $message = "Your password reset code is $code";
                $sender = "From: aryanbimali45@gmail.com";
                $sendmail = mail($email, $subject, $message, $sender);
                echo $sendmail;
                if($sendmail){
                    $info = "We've sent a passwrod reset otp to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location:reset-code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
                }
            }else{
                $errors['db-error'] = "Something went wrong!";
            }
        }else{
            $errors['email'] = "This email address does not exist!";
        }
    }





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="forgot-password.php" method="POST" autocomplete="">
                    <h2 class="text-center">Forgot Password</h2>
                    <p class="text-center">Enter your email address</p>
                    <?php
                        if(count($errors) > 0){
                            ?>
                            <div class="alert alert-danger text-center">
                                <?php 
                                    foreach($errors as $error){
                                        echo $error;
                                    }
                                ?>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Enter email address" required value="">
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="check-email" value="Continue">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>