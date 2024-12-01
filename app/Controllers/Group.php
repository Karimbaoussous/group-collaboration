<?php   

    namespace App\Controllers;

    use App\Models\GroupModel;
    use App\Models\MsgModel;
    use App\Models\UserModel;
    use Exception;

    class Group extends BaseController{


        private $groupModel, $msgModel, $userInSession, $userModel, $userInDB, $img;

        public function __construct(){

            $this->groupModel = new GroupModel();
            $this->msgModel =  new MsgModel();
            $this->userModel = new UserModel();
            $this->userInSession = session()->get('user');
            $this->userInDB = $this->userModel->getUserByEmail($this->userInSession['email']);
            $this->img = new Img();

        }


        private function joinMsgs($groupID){

            $listOfMsgs = $this->msgModel->getAll($groupID);

            if(!$listOfMsgs) return ;

            $listOut = [];

            // return $listOfMsgs;

            foreach($listOfMsgs as $msg){
                
                $msg['isRight']  = $msg['user'] == $this->userInDB['id'];

                $msg['src'] = $this->img->getLink(
                    $msg['user'], "user"
                );

                $msg['sender'] = $msg['username'];

                $listOut[] = $msg;

            }

           return $listOut;

        }


        public function load() {

            try{

                $groupID = $this->request->getPost(index: 'id');
            
                $groupData = $this->groupModel->getByID($groupID);

                if(!$groupData){
                    return $this->response->setJSON(
                        array( 'error' => 'an error acquired while loading group')
                    );
                }

                $creatorRow = $this->groupModel->getCreator($groupID);

                if(empty($creatorRow)){
                    return $this->response->setJSON(
                        array( 'alert' =>  "The group you're trying to access has no creator")
                    );
                }


                $userJoinedGroup = $this->groupModel->isJoinedBy(
                    $this->userInDB['id'], 
                    $groupID
                );

                // return $this->response->setJSON(
                //     array( 
                //         'msg' =>  $groupID . " ". $this->userInDB['id'] ." ".  $userJoinedGroup
                //     )
                // );

                if(!$userJoinedGroup){
                    return $this->response->setJSON(
                        array( 'joinRequest' =>  "true")
                    );
                }

                $groupData['image'] = $this->img->getLink( 
                    $groupData['id'], "group"
                );

                $this->userInSession["listOfMsgs"] = $this->joinMsgs($groupID);

                $this->userInSession["isAdmin"] = (
                    $creatorRow['id'] == $this->userInDB['id']
                );


                $htmlMSG = view(
                    "VChat/GroupInfosView/GroupInfosView", 
                    data: array(
                        "group" => $groupData
                    )
                );


                $htmlMSG .= view(
                    "VChat/ChatAreaView/ChatAreaView", 
                    $this->userInSession
                );

              
                $htmlMSG .= view(
                    name: "VChat/MsgInputView/MsgInputView", 
                    data: array(
                        // "group" => $groupData
                    )
                );

                    
                session()->set(
                    "group", 
                    value: $groupData
                );


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
            
                $groups = $this->groupModel->getJoinedByTitleLike(
                    $search, 
                    $this->userInDB['id'],
                    true
                );

                if($groups == []){
                    return $this->response->setJSON(
                        array(
                            'html' => view("VChat/GroupView/NothingView"),
                            "groupsNumber" => 0
                        )
                    );
                }


                $groups = $this->img->setLinks(
                    $groups, 
                    "image",
                    "id",
                    "group"
                );


                $htmlMSG = "";
                
                foreach($groups as $group){

                    $htmlMSG .= view(
                        "VChat/GroupView/GroupCardView", 
                        array(
                            "group" => $group
                        )
                    );
                    
                }

                // echo $data;
                return $this->response->setJSON(
                    array( 
                        'html' =>  $htmlMSG,
                        "groupsNumber" => sizeof($groups)
                    )
                );


            }catch(Exception $e){
       
                return $this->response->setJSON(
                    array( 'error' =>  "My Error Handler: ". $e->getMessage())
                );

            }
            
        }


        public function join(){

            try{

                $groupID = $this->request->getPost(index: 'id');
            
                $groupData = $this->groupModel->getByID($groupID);

                if(!$groupData){
                    return $this->response->setJSON(
                        array( 'error' => 'an error acquired while join group')
                    );
                }

                $creatorRow = $this->groupModel->getCreator($groupID);

                if(empty($creatorRow)){
                    return $this->response->setJSON(
                        array( 'alert' =>  "The group you're trying to join has no creator")
                    );
                }


                // return $this->response->setJSON(
                //     array( 
                //         'msg' =>  $this->img->getLink(  $groupData['id'], "group")
                //     )
                // );

                $groupData['image'] = $this->img->getLink( 
                    $groupData['id'], modelName: "group"
                );
                $creatorRow['image'] = $this->img->getLink( 
                    $creatorRow['id'], "user"
                );
        

                // make sure that admin must be the first to join group
                $userID = $this->userInDB['id'];

                $hasJoined = $this->groupModel->isJoinedBy(
                    $userID, 
                    $groupID
                );

                if(!$hasJoined){

                    $this->groupModel->joinGroup($groupID,  $userID);

                }


                $groupData['image'] = $this->img->getLink( 
                    $groupData['id'], "group"
                );

                $this->userInSession["listOfMsgs"] = $this->joinMsgs($groupID);
                $this->userInSession["isAdmin"] = $creatorRow['id'] == $userID;


                $htmlMSG = view(
                    "VChat/GroupInfosView/GroupInfosView", 
                    data: array(
                        "group" => $groupData
                    )
                );


                $htmlMSG .= view(
                    "VChat/ChatAreaView/ChatAreaView", 
                    $this->userInSession
                );

              
                $htmlMSG .= view(
                    name: "VChat/MsgInputView/MsgInputView", 
                    data: array(
                        // "group" => $groupData
                    )
                );

                    
                session()->set(
                    "group", 
                    value: $groupData
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


        public function joinRequest(){

            try{

                $groupID = $this->request->getPost(index: 'id');
            
                $groupData = $this->groupModel->getByID($groupID);

                if(!$groupData){
                    return $this->response->setJSON(
                        array( 'error' => 'an error acquired while join group request')
                    );
                }

                $creatorRow = $this->groupModel->getCreator($groupID);

                if(empty($creatorRow)){
                    return $this->response->setJSON(
                        array( 'alert' =>  "The group you're trying to join has no creator")
                    );
                }


                $groupData['image'] = $this->img->getLink( 
                    $groupData['id'], modelName: "group"
                );

                $creatorRow['image'] = $this->img->getLink( 
                    $creatorRow['id'], "user"
                );
        

                // make sure that admin must be the first to join group
                $userID = $this->userInDB['id'];

                $adminCase = $creatorRow['id'] ==  $userID;
 
                if($adminCase){
                    
                    $hasJoined = $this->groupModel->isJoinedBy(
                        $userID, 
                        $groupID
                    );

                    if(!$hasJoined){

                        $this->groupModel->joinGroup($groupID,  $userID);

                        return $this->response->setJSON(
                            array( 'alert' =>  "
                                A backend Error was acquired,
                                admin must be the 1st to join the group!
                            ")
                        );
                    }

                }


                $htmlMSG = view(
                    "VChat/JoinChatView/JoinChatView", 
                    data: array(
                        "group" => $groupData,
                        "user" => $creatorRow
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

        
    }


?>