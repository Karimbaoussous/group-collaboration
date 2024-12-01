<?php

    namespace App\Models;

    use CodeIgniter\Model;

    use Exception;

    class GroupModel extends Model {

        public $userID, $userModel;

        public function __construct(){

            parent::__construct(); // load database


            // $user = session()->get('user');
            // if(!$user) throw new Exception('invalid request');
            // $userModel = new UserModel(); 
            // $this->userID = $userModel->getUserIDByEmail(email: $user['email']);

        }


        // public function add($msg){
        
        //     try{

        //         $this->db->query(
        //             "
        //                 insert into msg (
        //                     body
        //                 ) values (
        //                     ?
        //                 )
        //             ", array(
        //                 $msg
        //             )
        //         );

        //         $msgID = $this->db->insertID();

        //         $this->db->query(
        //             "
        //                 insert into send (
        //                     user, msg
        //                 ) values (
        //                     ?, ?
        //                 )
        //             ", array(
        //                 $this->userID, $msgID
        //             )
        //         );

        //         return true;

        //     }catch(Exception $e ){

        //         return false;

        //     }
            
        // }


    
        public function getAll(){
        
            try{

                $query = $this->db->query("
                    select * from grp
                    where isPublic = true;
                ");

                return $query->getNumRows() > 0?  $query->getResultArray(): null;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function getCreator($groupID){

            try{

                $query = $this->db->query("
                    select * from user 
                    where id in (select user from created where grp = ?)
                    limit 1;
                    ", 
                    array($groupID)
                );

                return $query->getNumRows() > 0? $query->getRowArray(): null;
           
            }catch(Exception $e ){

                return $e->getMessage();

            }

        }

        
        public function getByID($id){

     
            try{

                $query = $this->db->query("
                    select * from grp 
                    where id = ?
                ", array($id));

                return $query->getNumRows() > 0?  $query->getRowArray(): null;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function getJoined($userID){
        
            try{

                $query = $this->db->query("
                    select * from grp
                    where 
                        id in (
                            select grp from joinGroup 
                            where user = ?
                        );
                ", array($userID));

                return $query->getNumRows() > 0?  $query->getResultArray(): null;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function joinGroup($groupID, $userID){
        
            try{

                $this->db->query(
                    "
                        insert into joinGroup (grp, user) values (?, ?)
                    ", array(
                        $groupID, $userID
                    )
                );

                return true;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function isJoinedBy($userID, $groupID){
        
            try{

                $query = $this->db->query("
                    select * from joinGroup
                    where user = ? and grp = ?
                    limit 1;
                ", array($userID, $groupID));

                return $query->getNumRows() > 0;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function getPublicNotJoined($userID){
        
            try{

                $query = $this->db->query("
                    select * from grp
                    where 
                        isPublic = true and 
                        id not in (
                            select grp from joinGroup 
                            where user = ?
                        );
                ", array($userID));

                return $query->getNumRows() > 0?  $query->getResultArray(): null;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function getJoinedMembers($groupID){
        
            try{

                $query = $this->db->query("
                        select 
                            *,
                            (select true from created where user = id and grp = ?) as isAdmin
                        from 
                            user
                        where 
                            id in (select distinct user from joinGroup where grp = ?)
                        order by isAdmin desc
                    ",
                    array(
                        $groupID, $groupID
                    )
                );

                return $query->getNumRows() > 0?  $query->getResultArray(): null;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function getJoinedMembersLike($username, $groupID){

            try{

                $query = $this->db->query("
                    select * 
                    from 
                        (
                            select 
                                *,
                                (select true from created where user = id and grp = ?) as isAdmin
                            from 
                                user
                            where 
                                id in (
                                    select distinct user from joinGroup where grp = ? 
                                )
                            order by isAdmin desc
                        ) as groupMembers
                    where 
                        username like CONCAT('%', ?, '%');
                    ",
                    array(
                        $groupID, $groupID, $username
                    )
                );

                return $query->getResultArray();

            }catch(Exception $e ){

                return false;

            }
        
            
        }


        public function getJoinedByTitleLike($title, $userID, $isPublic=false){
        
            try{

                $query = $this->db->query("
                    select * from grp
                    where 
                        (
                            id in ( select grp from joinGroup where user = ? ) 
                            or
                            isPublic = ?
                        )
                        and
                        title like CONCAT('%', ?, '%');
                    ", 
                    array($userID, $isPublic, $title)
                );

                return $query->getResultArray();

            }catch(Exception $e ){

                return false;

            }
            
        }

        
        public function removeJoinedMember($groupID, $memberID){
        
            try{

                $query = $this->db->query("
                    delete from joinGroup 
                    where grp = ? and user = ?
                ", 
                    array(
                        $groupID, $memberID
                    )
                );

                return true;

            }catch(Exception $e ){

                return false;

            }
            
        }


        public function hasMsgs($groupID){
        
            try{

                $query = $this->db->query("
                    select count(*) as num from send 
                    where grp = ?
                    limit 1;
                ",
                    binds: array($groupID)
                );

                return $query->getNumRows() > 0;

            }catch(Exception $e ){

                return false;

            }
            
        }

        
        public function getImg($groupID){
        
            try{

                $query = $this->db->query("
                    select image from grp 
                    where id = ?
                    limit 1;
                ",
                    binds: array($groupID)
                );

                return $query->getNumRows() > 0? $query->getRowArray()["image"]: null;

            }catch(Exception $e ){

                return false;

            }
            
        }





        
    }


?>