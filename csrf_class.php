<?php
/*
* Hackers use CSRF attacks using token manipulation (with hidden values) to process  fraud  on trasactions per example 
* Laravel PHP framework implements this type of security using the constant 'CSFR' on forms on submit section
* */
abstract class CSRF {
    
    // Force Extending class to define this method
    abstract protected function generate_token();


    public function get_token() : string{
     return $this->generate_token();
    }
}


class Token extends CSRF{
    protected string $tooken;

    public function generate_token() : string{
       return bin2hex(random_bytes(35));

    }
    
 

    public function eval_token(string $post_token) : string{
        // user tooken 
        try{
        /**
         * Use this  code above if you are sumitting  token from form , on a input called  'token' 
         */
        #$tooken =  filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
       

        if($post_token=='' || $post_token !==$_SESSION['token'] ){
            die('Invalid token');
        }else{
             // process form here
             return 'form processed ok';
        }

        }catch(\InvalidArgumentException $e){

            return $e->getMessage();
        }

        }
}

   


session_start();
$csrf = new Token;
$token = $csrf->generate_token();
$_SESSION['token'] = $token;
 // a non token validation allowed to hacker manipulate the token , 
 // processing bad information like increase amounts and changing page destination
 echo $csrf->eval_token('dfdfghr65757rtjfgng');  
?>