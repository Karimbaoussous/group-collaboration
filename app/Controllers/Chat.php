<?php   

    namespace App\Controllers;

    use App\Models\GroupModel;
    use App\Models\MsgModel;
    use App\Models\UserModel;

    class Chat extends BaseController{

        protected $msgModel,$userInDB, $userModel, $userInSession;

      
        public function index(){

            //reset group selection
            session()->set('group', null);

            $this->userInSession = session()->get('user');

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
            $groups2 =  $groupModel->getPublicNotJoined($this->userInDB['id']);

            // return $this->response->setJSON(array(
            //     "msg" =>  $groups2)
            // );

         

            $groups = $groups1? array_merge($groups1, $groups2): $groups2;
            

            //give each image a link
            if($groups){

                $groups = $img->setLinks(
                    table: $groups, 
                    att1: "image",
                    id: "id",
                    modelName: "group"
                );  
                  
            }
            // print_r(value: $groups );
            // return;

            return view(
                'VChat/chatView', 
                array(
                    "user"      => $this->userInSession,
                    "groups"    => $groups
                )
            );
          
        }

        // http://localhost:8080/chat/id/5
        public function ID($id){
            echo "chat ID: $id";
        }
        
    }

?>