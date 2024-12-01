<?php

    namespace App\Models;

    use CodeIgniter\Model;
    use DateTime;
    use Exception;

    class MsgModel extends Model {

        public $userID, $userModel;

        public function __construct(){

            parent::__construct(); // load database

            $user = session()->get('user');
            if(!$user) throw new Exception(message: 'missing user');

            $userModel = new UserModel(); 

            $this->userID = $userModel->getUserIDByEmail(email: $user['email']);

        }


        public function add($msg, $groupID){

            if(strlen($msg) == 0){
                throw new Exception("empty msg");
            }

            try{

                $this->db->query(
                    "
                        insert into msg (
                            body
                        ) values (
                            ?
                        )
                    ", array(
                        $msg
                    )
                );

                $msgID = $this->db->insertID();

                $this->db->query(
                    "
                        insert into send (
                            user, msg, grp
                        ) values (
                            ?, ?, ?
                        )
                    ", array(
                        $this->userID, $msgID, $groupID
                    )
                );

                return $msgID;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function remove($msgID, $groupID){

            if(!(is_numeric($msgID) && is_numeric($groupID))){
                throw new Exception("msgID  or groupID is not a number"); 
            }

            try{

                // Begin the transaction
                $this->db->transBegin();

                // return "
                //     DELETE send FROM send 
                //     where
                //     user =  $this->userID and msg = $msgID and grp = $groupID;
                // ";

                $this->db->query(
                    "
                        DELETE send FROM send 
                        where
                        user = ? and msg = ? and grp = ?;
                    ", array(
                        $this->userID, $msgID, $groupID
                    )
                );

                $this->db->query(
                    "
                        DELETE msg FROM msg 
                        where 
                        id = ?;
                    ", array(
                        $msgID
                    )
                );
                
                $this->db->transCommit();

                return true;

            }catch(Exception $e ){
                
                $this->db->transRollback();

                // Log the error for debugging
                error_log("Error deleting message: " . $e->getMessage());
                return false;

            }
            
        }


        public function getAll($groupID){
        
            try{

                $query = $this->db->query("
                    select 
                    * , (select username from user where id = s.user) as username
                    from 
                        msg m, send s
                    where 
                        m.id = s.msg and s.grp = ?
                ",
                    binds: array($groupID)
                );

                return $query->getNumRows() > 0?  $query->getResultArray(): null;

            }catch(Exception $e ){

                return false;

            }
            
        }

       
        public function getSender($msgID){
        
            try{

                $query = $this->db->query("
                    select * from user 
                    where id in (select user from send where msg = ?)
                    limit 1;
                ",
                    binds: array($msgID)
                );

                return $query->getNumRows() > 0?  $query->getRowArray(): null;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function getLastSentDate($groupID){
        
            try{

                $query = $this->db->query("
                    select max(date) as date from send 
                    where grp = ?
                    limit 1;
                ",
                    binds: array($groupID)
                );

                if($query->getNumRows() > 0){

                    $date = new DateTime( $query->getRowArray()["date"]);
                    return $date->format('Y-m-d');
                    
                }else{

                    return null;

                }  
                
            }catch(Exception $e ){

                return false;

            }
            
        }


    }


?>