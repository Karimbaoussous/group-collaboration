<?php

    namespace App\Models;

    use App\Libraries\MyHelper;
    use CodeIgniter\Model;
    use Exception;


    class UserModel extends Model {

        protected $myHelper;
        protected $table    = 'user';


        public function __construct(){

            // $this->load does not exist until after you call this
            parent::__construct(); // load database

            $this->myHelper = new MyHelper();

        }


        
        

        public function checkEmailExistence($email){
            
            $query = $this->db->query(
                "
                SELECT id FROM user 
                WHERE email = ? 
                ", array($email)
            );
            return $query->getNumRows() > 0;

        }


        public function getUserByEmail($email){
            
            $query = $this->db->query(
                "select * from user where email = ? limit 1",
                array($email)
            );
            return $query->getNumRows() == 1? $query->getRowArray(): null;

        }


        public function getUserIDByEmail($email){
           
            return $this->getUserByEmail($email)['id'];

        }


        public function checkLogin($email, $password){

            $user = $this->getUserByEmail($email);
            if($user == null) return null;
            return password_verify($password, $user["password"])? $user: null;

        }


        public function getAll($limit=0){

            $query = null;
            if(isset($limit) && $limit > 0){
                $query = $this->db->query(
                    "select * from user limit ?",
                    array($limit)
                );
            }else{
                $query = $this->db->query("select * from user");
            }

            return  $query->getNumRows() > 0?  $query->getResultArray(): null;

        }

        public function getAllInGroup($groupID){

            $query = $this->db->query(
                "
                select * from user u, send s
                where
                    u.id = s.user and s.grp = ?
                ",
                array($groupID)
            );
          
            return  $query->getNumRows() > 0?  $query->getResultArray(): null;

        }


        public function getUserById($id){

            $query = $this->db->query( 
                "select * from user where id = ?", 
                array($id)
            );
            $result = $query->getResultArray();
            return $query->getNumRows() > 0? $result: null;

        }
        

        public function add($user){
        
            try{

                $this->myHelper->keysValidation($user,
                    array("username", "email", "password")
                );

                $this->db->query(
                    "
                        insert into user (
                            username, email, password 
                        ) values (
                            ?, ?, ?
                        )
                    ", array(
                        $user['username'], $user['email'], 
                        // securely add password
                        password_hash($user['password'], PASSWORD_DEFAULT) 
                    )
                );

                return true;

            }catch(Exception $e ){

                return false;

            }
            
        }

        public function updatePassword($email, $newPassword){
        
            try{

                $this->db->query(
                    "
                        update user 
                        set password  = ? 
                        where email = ?
                    ", array(
                        password_hash($newPassword, PASSWORD_DEFAULT), 
                        $email
                    )
                );

                return true;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function googleAdd($user){
        
            try{

                $this->myHelper->keysValidation( $user,
                    array("fname", 'lname', "username", "email", "googleID")
                );

                
                $this->db->query(
                    "
                        insert into user (
                            fname, lname, username, email, googleID 
                        ) values (
                            ?, ?, ?, ?, ?
                        )
                    ", array(
                        $user['fname'], $user['lname'], $user['username'], $user['email'], 
                        $user["googleID"]
                    )
                );

                return true;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function googleUpdate($user){
        
            try{

                $this->myHelper->keysValidation( $user,
                    array("fname", 'lname', "username", "email", "googleID")
                );

                $this->db->query(
                    "
                        update 
                            user 
                        set 
                            fname = ?, lname = ?, username = ?, googleID = ? 
                        where
                            email = ?
                    ", array(
                        $user['fname'], $user['lname'], $user['username'], $user["googleID"], 
                        $user['email']
                    )
                );

                return true;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function updateImage($email, $img){
        
            try{

                $query = $this->db->query(
                    "

                        update user 
                        set image = ?
                        where email = ?

                    ", array(
                        $img, $email
                    )
                );

                return true;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function updateProfile($data, $email){
        
            try{

                $this->myHelper->keysValidation(user: $data,
                    args: array(
                        "username", "about", "phone", "link1",
                        "link2", "link3", "link4"
                    )
                );

                $this->db->query(
                    "
                    UPDATE user 
                    SET 
                        username = ?, about = ?, phone = ?, link1 = ?,
                        link2 = ?, link3 = ?, link4 = ?, contactEmail = ?,
                        fname = ?, lname = ?, born = ?
                    WHERE 
                        email = ?
                    ",
                    array(
                        $data["username"], $data["about"], $data["phone"],
                        $data["link1"], $data["link2"], $data["link3"], 
                        $data["link4"], $data["contactEmail"], $data["fname"], 
                        $data["lname"],  $data["born"], $email
                    )
                    
                );

                return true;

            }catch(Exception $e ){

                return $e->getMessage();

            }
            
        }
        

        public function getImg($userID){
        
            try{

                $query = $this->db->query("
                    select image from user 
                    where id = ?
                    limit 1;
                ",
                    binds: array($userID)
                );

                return $query->getNumRows() > 0? $query->getRowArray()["image"]: null;

            }catch(Exception $e ){

                return false;

            }
            
        }
        
        
    }


?>