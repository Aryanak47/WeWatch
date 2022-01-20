<?php 
    class FormSanitizer {

        public static function  sanitizeInput($input){
            $input = strip_tags($input);
            $input = trim($input);
            $input = strtolower($input);
            $input = ucfirst($input);
            return $input;
        }
        public static function  sanitizeUsername($input){
            $input = strip_tags($input);
            $input = trim($input);
            return $input;
        }
        public static function  sanitizePassword($input){
            $input = strip_tags($input);
            return $input;
        }
        public static function  sanitizeEmail($input){
            $input = strip_tags($input);
            return $input;
        }
    }
    
?>