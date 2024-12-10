<?php   

    namespace App\Controllers;

    use App\Models\GroupModel;
    use App\Models\UserModel;

    class Chat extends BaseController{

        protected $msgModel,$userInDB, $userModel, $userInSession;

      
        public function index(){

            //reset group selection
            session()->set('group', null);

            $this->userInSession = session()->get('user');

            if(!$this->userInSession){
                return view( "Global/alert", 
                    array(
                        "msg" => "Something went wrong, You must login again!",
                        "redirect" => "/login"
                    )
                );
            }


            $this->userModel = new UserModel();
            $this->userInDB = $this->userModel->getUserByEmail(
                $this->userInSession['email']
            );

            if($this->userInSession == null){
                return view('Global/alert', [
                    "msg"       => "invalid access",
                    "redirect"  => "login/"
                ]);
            }

            $img = new Img();

            $groupModel = new GroupModel();
            $groups1 =  $groupModel->getJoined($this->userInDB['id']);
            $groups2 =  $groupModel->getPublicNotJoinedNotInvited($this->userInDB['id']);

            // return $this->response->setJSON(array(
            //     "msg" =>  $groups2)
            // );

         

            $groups = $groups1;
            if($groups1 && $groups2){
                $groups =array_merge($groups1, $groups2);
            }else if( $groups2){
                $groups = $groups2;
            }
            

            //give each image a link
            if($groups){

                $groups = $img->setLinks(
                    table: $groups, 
                    att1: "image",
                    id: "id",
                    modelName: "group"
                );  
                  
            }



            return view(
                'VChat/chatView', 
                array(
                    "user"          => $this->userInSession,
                    "groups"        => $groups,
                    "invitations"   => []
                )
            );
          
        }

        // http://localhost:8080/chat/id/5
        public function ID($id){
            echo "chat ID: $id";
        }
        
    }

?>