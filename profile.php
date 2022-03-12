<?php
require_once("includes/header.php");
$detailsMessage = "";
$passwordMessage = "";

if(isset($_POST["saveDetailsButton"])) {
    $account = new Account($conn);

    $firstName = FormSanitizer::sanitizeInput($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeInput($_POST["lastName"]);
    $email = FormSanitizer::sanitizeEmail($_POST["email"]);

    if($account->updateDetails($firstName, $lastName, $email, $userLoggedIn)) {
        $detailsMessage = "<div class='alertSuccess'>
                                Details updated successfully!
                            </div>";
    }
    else {
        $errorMessage = $account->getFirstError();

        $detailsMessage = "<div class='alertError'>
                                <span class='error'>$errorMessage</span>
                            </div>";
    }
}

if(isset($_POST["savePasswordButton"])) {
    $account = new Account($conn);

    $oldPassword = FormSanitizer::sanitizePassword($_POST["oldPassword"]); 
    $newPassword = FormSanitizer::sanitizePassword($_POST["newPassword"]);
    $newPassword2 = FormSanitizer::sanitizePassword($_POST["newPassword2"]);

    if($account->updatePassword($oldPassword, $newPassword, $newPassword2, $userLoggedIn)) {
        $passwordMessage = "<div class='alertSuccess'>
                                Password updated successfully!
                            </div>";
    }
    else {
        $errorMessage = $account->getFirstError();

        $passwordMessage = "<div class='alertError'>
                                $errorMessage
                            </div>";
    }
}

?>

<div class="settingsContainer column">

    <div class="formSection">

        <form method="POST">

            <h2>User details</h2>
            
            <?php
            $user = new User($conn, $userLoggedIn);

            $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : $user->getFirstName();
            $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : $user->getLastName();
            $email = isset($_POST["email"]) ? $_POST["email"] : $user->getEmail();
            ?>

            <input type="text" name="firstName" placeholder="First name" value="<?php echo $firstName; ?>">
            <input type="text" name="lastName" placeholder="Last name" value="<?php echo $lastName; ?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">

            <div class="message">
                <?php echo $detailsMessage; ?>
            </div>
            
            <input type="submit" name="saveDetailsButton" value="Save">


        </form>

    </div>

    <div class="formSection">

        <form method="POST">

            <h2>Update password</h2>

            <input type="password" name="oldPassword" placeholder="Old password">
            <input type="password" name="newPassword" placeholder="New password">
            <input type="password" name="newPassword2" placeholder="Confirm new password">

            <div class="message">
                <?php echo $passwordMessage; ?>
            </div>

            <input type="submit" name="savePasswordButton" value="Save">


        </form>

    </div>

    <div class="formSection">
        <h2>Subscription</h2>

        <?php

        if($user->getIsSubscribed()) {
            echo "<h3>You are subscribed! Go to PayPal to cancel.</h3>";
        }
        else {
            echo "<a href='billing.php'>Subscribe to Reeceflix</a>";
        }
        ?>
    </div>

</div>