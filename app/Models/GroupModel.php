<?php

    namespace App\Models;

    use CodeIgniter\Model;

    use Exception;

    class GroupModel extends Model {

        public $userModel;

        public function __construct(){

            parent::__construct(); // load database

        }


        public function exists($title){
        
            try{

                $query = $this->db->query(
                    "
                        select count(*) as num from grp 
                        where title = ?
                    ", array(
                        $title,
                    )
                );


                return $query->getRowArray()["num"] == 1;

            }catch(Exception $e ){


                return "Error: " . $e->getMessage();

            }
            
        }


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


        public function getPublicNotJoinedNotInvited($userID){
        
            try{

                $query = $this->db->query("
                    select * from grp
                    where 
                        isPublic = true and 
                        id not in (
                            select grp from joinGroup 
                            where user = ?
                        )
                    and id not in (
                        select grp from invite 
                        where user = ?
                    );
                ", array($userID, $userID));

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
                            (
                                isPublic = ? and 
                                id not in ( select grp from invite where user = ? )
                            )
                        )
                        and
                        title like CONCAT('%', ?, '%');
                    ", 
                    array($userID, $isPublic, $userID, $title)
                );

                return $query->getResultArray();

            }catch(Exception $e ){

                return false;

            }
            
        }


        private function removeAllMsgsOFuserInGroup($userID, $groupID){


            $query = $this->db->query(
                "
                    select msg as id from send 
                    where 
                        user = ? and grp = ?
                ",
                array($userID, $groupID)
            );


            // delete link to msgs
            $this->db->query(
                "
                    delete from send 
                    where user = ? and grp = ?
                ",
                array($userID, $groupID)
            );

            $msgs =  $query->getResultArray();

            foreach($msgs as $msg){

                $this->db->query(
                    "delete from msg where id = ?",
                    array($msg["id"])
                );

            }

            $msgs = array(); // free memory space

        }


        public function removeJoinedMember($groupID, $memberID){
        
            try{

                $this->db->transBegin();

                $this->removeAllMsgsOFuserInGroup(
                    userID: $memberID, 
                    groupID: $groupID
                );

                $this->db->query("
                    delete from joinGroup 
                    where 
                        grp = ? and user = ?
                ", 
                    array(
                        $groupID, $memberID
                    )
                );

                $this->db->transCommit();

                return true;

            }catch(Exception $e ){

                $this->db->transRollback();

                return $e->getMessage();

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

                return $query->getRowArray()["num"] > 0;

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

        
        public function isItLastMsgInThatDay($groupID, $msgID){
        
            try{

                $query = $this->db->query("     
                    select
                        count(*) as num 
                    from 
                        send, 
                        (select date, grp from send where grp = ? and msg = ?) as dt
                    where
                        DATEDIFF(send.date, dt.date) = 0 and 
                        send.grp = dt.grp and 
                        send.grp  = ?
                    ;
                ",
                    binds: array( $groupID, $msgID, $groupID )
                );

                // will return message it self only
                return $query->getRowArray()["num"] == 1;
                
            }catch(Exception $e ){

                return false;

            }
            
        }


        
    }


?>