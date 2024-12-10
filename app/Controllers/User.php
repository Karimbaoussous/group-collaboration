<?php

    namespace App\Controllers;

    use App\Models\GroupModel;
    use App\Models\MsgModel;
    use App\Models\UserModel;
    use Exception;

    class User extends BaseController{

        private $groupModel, $msgModel, $userInSession, $userModel, $userInDB, $imgy;

        public function __construct(){

            $this->groupModel = new GroupModel();
            $this->msgModel =  new MsgModel();
            $this->userModel = new UserModel();
            $this->userInSession = session()->get('user');
            $this->userInDB = $this->userModel->getUserByEmail($this->userInSession['email']);
            $this->imgy = new Img();

        }


        public function search() {

            try{

                //retrieve session data
                if($this->userInSession == null){
                    return $this->response->setJSON(
                        array( 
                            'error' =>  "An error was acquired while searching for users"
                            )
                    );
                }

                $search = $this->request->getPost(index: 'search');

          

                $users = $this->userModel->getLike(
                    $search, $this->userInDB['id'] 
                );

                $users = $this->imgy->setLinks(
                    table: $users, 
                    att1: 'image',
                    id: "id",
                    modelName: "user"
                );



                if($users == []){
                    return $this->response->setJSON(
                        array(
                            'html' => view("VChat/GroupView/NothingView"),
                            "usersNumber" => 0
                        )
                    );
                }

                // return $this->response->setJSON(
                //     array( 'msg' =>  $members)
                // );

                $sid = session()->session_id;

                $localUserInSession = session()->get($sid);

                $invitations = isset($localUserInSession["invitations"])?  $localUserInSession["invitations"]: [];

            
                $htmlMSG = "";

                foreach($users as $user){

                    $htmlMSG .= view(
                        "VChat/CreateGroupView/UserCardView", 
                        array(
                            "user"=> $user,
                            "userID" => $this->userInDB["id"],
                            "invitations" => $invitations
                        )
                    );
                    
                }

                // return $this->response->setJSON(
                //     body: array( 'msg' =>  $localUserInSession)
                // );


                return $this->response->setJSON(
                    array( 
                        'html' =>  $htmlMSG,
                        "usersNumber" => sizeof(value: $users)
                    )
                );


            }catch(Exception $e){

                return $this->response->setJSON(
                    array( 'error' =>  "My Error Handler: ". $e->getMessage())
                );

            }

        }
		

    }