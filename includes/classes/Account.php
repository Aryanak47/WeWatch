<?php 
    class Account {
        private $con;
        private $err = array();

        public function __construct($con) {
            $this->con = $con;
        }
        public function updateDetails($fn, $ln, $em, $un) {
            $this->validFirstName($fn);
            $this->validLastName($ln);
            $this->validateNewEmail($em, $un);
    
            if(empty($this->err)) {
                $query = $this->con->prepare("UPDATE users SET firstName=:fn, lastName=:ln, email=:em
                                                WHERE username=:un");
                $query->bindValue(":fn", $fn);
                $query->bindValue(":ln", $ln);
                $query->bindValue(":em", $em);
                $query->bindValue(":un", $un);
    
                return $query->execute();
            }
    
            return false;
        }


        public function login($uemail, $password){
            $found = false;
            $hashedPassword = hash('sha512',$password);
            $query = $this->con->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
            $query->bindValue(':username',$uemail);
            $query->bindValue(':password',$hashedPassword);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);
            if ($query->rowCount() > 0 ){
                if($data['ban']){
                    array_push($this->err,Constant::$banError);
                    return false;
                }
                $_SESSION['role']=$data['role'];
                return true;
            }
            array_push($this->err,Constant::$loginError);
            return false;
        }
      


        public function register($em,$em2,$user,$fName,$lName,$pw,$pw2) {
            $this->validFirstName($fName);
            $this->validLastName($lName);
            $this->validEmail($em,$em2);
            $this->validUsername($user);
            $this->validPassword($pw,$pw2);
            $totalErrors = count($this->err);
            if($totalErrors > 0) {
                return false; ;
            }
            //  saving user information in database
            // hash password
            $password = hash('sha512',$pw);
            $query = $this->con->prepare("INSERT INTO `users` (`firstName` ,`lastName` ,`username` ,`email` ,`password`)VALUES(:fname,:lname,:uname,:email,:pw)");
            $query->bindValue(':fname',$fName);
            $query->bindValue(':lname',$lName);
            $query->bindValue(":pw",$password);
            $query->bindValue(':email',$em);
            $query->bindValue(":uname",$user);
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return $query->execute();
        }
        private function validFirstName($fn){
            if(strlen($fn)  < 2 || strlen($fn) > 25){
                array_push($this->err,Constant::$firstNameError);
            }
            return;
        }
        public function validLastName($fn){
            if(strlen($fn)  < 2 || strlen($fn) > 25){
                array_push($this->err,Constant::$lastNameError);
            }
            return;
        }
        public function validEmail($em,$em2){
            if($em != $em2){
                array_push($this->err,Constant::$emailMatchError);
                return;

            }
            if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
                array_push($this->err,Constant::$emailError);
            }
            $query = $this->con->prepare( "SELECT * FROM users WHERE email=:em" );
            $query->bindValue(":em", $em );
            $query->execute();
            if( $query->rowCount() > 0 ) { 
                array_push($this->err,Constant::$emailTakenError);
            }
            
            
        }
        
    private function validateNewEmail($em, $un) {

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->err, Constants::$emailError);
            return;
        }

        $query = $this->con->prepare("SELECT * FROM users WHERE email=:em AND username != :un");
        $query->bindValue(":em", $em);
        $query->bindValue(":un", $un);

        $query->execute();
        
        if($query->rowCount() != 0) {
            array_push($this->err, Constant::$emailTakenError);
        }
    }
        public function validUsername($fn){
            if(strlen($fn)  < 2 || strlen($fn) > 25){
                array_push($this->err,Constant::$usernameError);
                return;
            } 
            $query = $this->con->prepare( "SELECT * FROM users WHERE username=:un" );
            $query->bindValue(":un", $fn );
            $query->execute();
            if( $query->rowCount() > 0 ) { 
                array_push($this->err,Constant::$usernameTakenError);
            }
        }
        public function validPassword($pw,$pw2){
            if($pw != $pw2){
                array_push($this->err,Constant::$passwordMatchError);
                return;
            }

            if(strlen($pw)  < 8 || strlen($pw) > 25){
                array_push($this->err,Constant::$passwordError);
              } 
        }


        public function getErrorMessage($error){
            if(in_array($error,$this->err)){
                return $error;
            }

        }
        public function getFirstError() {
            if(!empty($this->err)) {
                return $this->err[0];
            }
        }
        public function updatePassword($oldPw, $pw, $pw2, $un) {
            $this->validateOldPassword($oldPw, $un);
            $this->validPassword($pw, $pw2);
    
            if(empty($this->err)) {
                $query = $this->con->prepare("UPDATE users SET password=:pw WHERE username=:un");
                $pw = hash("sha512", $pw);
                $query->bindValue(":pw", $pw);
                $query->bindValue(":un", $un);
    
                return $query->execute();
            }
    
            return false;
        }
    
        public function validateOldPassword($oldPw, $un) {
            $pw = hash("sha512", $oldPw);
    
            $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
            $query->bindValue(":un", $un);
            $query->bindValue(":pw", $pw);
    
            $query->execute();
    
            if($query->rowCount() == 0) {
                array_push($this->err, Constant::$passwordIncorrect);
            }
        }
    }


?>