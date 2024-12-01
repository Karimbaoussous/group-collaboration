<?php 

    namespace App\Libraries;

    use Exception;
    
    class MyHelper{


        public function __construct(){

        }


        public function keysValidation($user, $args){

            foreach($args as $val){
    
                if(!isset($user[$val])) {
                    throw new Exception("MyHelper Value Error: user[$val] = $user[$val]");
                }
            
            }
        }


    }

    
?>