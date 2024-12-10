<?php

    namespace App\Models;

    use CodeIgniter\Model;
    use DateTime;
    use Exception;

    class SendModel extends Model {

        public $userID, $userModel;

        public function __construct(){

            parent::__construct(); // load database

            $user = session()->get('user');
            if(!$user) throw new Exception(message: 'missing user');

            $userModel = new UserModel(); 

            $this->userID = $userModel->getUserIDByEmail(email: $user['email']);

        }


       

        
        public function getSenderIdByMsgID($msgID){
        
            try{

                $query = $this->db->query("
                    select user as id from send where msg = ? 
                    limit 1;
                ",
                    binds: array( $msgID )
                );

                return $query->getRowArray()["id"];
                
            }catch(Exception $e ){

                return false;

            }
            
        }



    }


?>