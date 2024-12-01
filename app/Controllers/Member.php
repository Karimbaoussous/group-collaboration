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
            
                $groupData = session()->get("group");

                if(!$groupData){
                    return $this->response->setJSON(
                        array( 'error' => 'an error acquired while loading members')
                    );
                }


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
                        "group" => $groupData,
                        "members" => $members,
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

                $groupData = session()->get("group");


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
                            "isAdmin" => $isAdmin
                        )
                    );
                    
                }

                // echo $data;
                return $this->response->setJSON(
                    array( 
                        'html' =>  $htmlMSG,
                        "membersNumber" => sizeof($members),
                        "isAdmin" => $isAdmin
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

                $groupData = session()->get("group");

                if(!$groupData){
                    return $this->response->setJSON(
                        array( 'alert' => 'an error acquired while removing a member')
                    );
                }

                $groupID = $groupData['id'];

                $isAdmin =  (
                    $this->groupModel->getCreator( $groupID)['id'] == $memberID
                );
            
                if($isAdmin){
                    return $this->response->setJSON(
                        array( 'alert' => 'you cant remove this member')
                    );
                }

                $status = $this->groupModel->removeJoinedMember(
                    $groupID, 
                    $memberID
                );

                if(!$status){

                    // echo $data;
                    return $this->response->setJSON(
                        array( 
                            'alert' =>  "failed to removing a member",
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
