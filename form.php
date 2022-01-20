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
                <a href="#" class="login__link">Already have an account ? sign in here !</a>

            </form>
        </div>