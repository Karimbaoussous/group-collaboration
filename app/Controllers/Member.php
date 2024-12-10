<?php

    namespace App\Controllers;

    use App\Models\GroupModel;
    use App\Models\MsgModel;
    use App\Models\UserModel;
    use Exception;

    class Member extends BaseController{

        private $groupModel, $userModel, $userInSession, $userInDB, $img;

        public function __construct(){

            $this->userInSession = session()->get('user');

            if(!$this->userInSession){
                throw new Exception("Something went wrong, You must login again!");
            }

            $this->groupModel = new GroupModel();

            $this->userModel = new UserModel();

            $this->userInDB = $this->userModel->getUserByEmail($this->userInSession['email']);

            $this->img = new Img();

        }

 
        public function load() {

            try{


                $groupID = $this->request->getPost(index: 'id');

                if(!$groupID){
                    return $this->response->setJSON(
                        array( 'error' => 'please select a group')
                    );
                }
            
                $groupInSession = session()->get("group");

                if(!$groupInSession){
                    return $this->response->setJSON(
                        array( 'error' => 'an error acquired while loading members')
                    );
                }

                // $group =  $this->groupModel->getByID($groupID);

                // print_r( $group);
                // return;

                $groupInSession['image'] = $this->img->getLink($groupID, "group");

                $members =  $this->groupModel->getJoinedMembers($groupID);

                $members = $this->img->setLinks(
                    $members, 
                    'image',
                    "id",
                    "user"
                );

            
                $htmlMSG = view(
                    name: "VChat/MembersOFGroupView/MembersOFGroupView", 
                    data: array(
                        "group" => $groupInSession,
                        "members" => $members,
                        "userID" => $this->userInDB["id"],
                        "isAdmin" => (
                            $this->groupModel->getCreator($groupID)['id'] == $this->userInDB['id']
                            // true
                        )
                    )
                );


                // echo $data;
                return $this->response->setJSON(
                    array( 'html' =>  $htmlMSG)
                );


            }catch(Exception $e){

                return $this->response->setJSON(
                    array( 'error' =>  "My Error Handler: ". $e->getMessage())
                );

            }

        }

        
        public function search() {

            try{

                $search = $this->request->getPost(index: 'search');

                $groupData = session()->get(key: "group");


                if(!$groupData){
                    return $this->response->setJSON(
                        array( 'error' => 'an error acquired while searching for members')
                    );
                }

                $groupID = $groupData['id'];
            
                $members = $this->groupModel->getJoinedMembersLike(
                    $search,   $groupID
                );

                $members = $this->img->setLinks(
                    $members, 
                    'image',
                    "id",
                    "user"
                );


                if($members == []){
                    return $this->response->setJSON(
                        array(
                            'html' => view("VChat/GroupView/NothingView"),
                            "membersNumber" => 0
                        )
                    );
                }

                // return $this->response->setJSON(
                //     array( 'msg' =>  $members)
                // );

                $isAdmin = (
                    $this->groupModel->getCreator($groupID)['id'] == $this->userInDB['id']
                    // true
                );


                $htmlMSG = "";

                foreach($members as $member){

                    $htmlMSG .= view(
                        "VChat/MembersOFGroupView/MemberOfGroupView", 
                        array(
                            "member" => $member,
                            "isAdmin" => $isAdmin,
                            "userID" => $this->userInDB["id"],
                        )
                    );
                    
                }

                // echo $data;
                return $this->response->setJSON(
                    array( 
                        'html' =>  $htmlMSG,
                        "membersNumber" => sizeof($members)
                    )
                );


            }catch(Exception $e){

                return $this->response->setJSON(
                    array( 'error' =>  "My Error Handler: ". $e->getMessage())
                );

            }
            
        }


        public function remove() {

            try{

                $memberID = $this->request->getPost(index: 'id');

                if(!is_numeric($memberID)){
                    return $this->response->setJSON(
                        array('alert' => "unknown member to remove")
                    );
                }

                $groupData = session()->get("group");

                if(!$groupData){
                    return $this->response->setJSON(
                        array( 'alert' => 'an error acquired while removing a member')
                    );
                }

                $groupID = $groupData['id'];

                $admin =  $this->groupModel->getCreator( $groupID);

                $isMemberAdmin =  (
                    $admin['id'] == $memberID
                );
            
                if($isMemberAdmin){
                    return $this->response->setJSON(
                        array( 'alert' => 'you cant remove this member')
                    );
                }

                $currentUser = $memberID == $this->userInDB['id']; // the current user wanna remove him self
                $isAdmin = $admin['id'] ==  $this->userInDB['id']; // the current user is admin

                if(!($currentUser ||  $isAdmin) ){
                    return $this->response->setJSON(
                        array( 'alert' => 
                        "you are not allowed to do this action $currentUser - $isAdmin - $memberID - ". $this->userInDB['id'])
                    );
                }

                $status = $this->groupModel->removeJoinedMember(
                    $groupID, 
                    $memberID
                );


                // return $this->response->setJSON(
                //     array( 
                //         'msg' =>  $status,
                //     )
                // );

                if( gettype($status) == 'string' ){

                    // echo $data;
                    return $this->response->setJSON(
                        array( 
                            'error' =>  "$status",
                        )
                    );

                }

                // echo $data;
                return $this->response->setJSON(
                    array( 
                        'status' =>  "ok",
                    )
                );


            }catch(Exception $e){

                return $this->response->setJSON(
                    array( 'error' =>  "My Error Handler: ". $e->getMessage())
                );

            }
            
        }

    
    }
