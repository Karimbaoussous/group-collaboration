<?php   

    namespace App\Controllers;

    use App\Models\GroupModel;
    use App\Models\MsgModel;
    use App\Models\UserModel;
use Exception;

    class Msg extends BaseController{


        private $msgModel, $userModel, $userInDB, $groupModel;

        public function __construct(){

            $this->groupModel = new GroupModel();
            $this->msgModel =  new MsgModel();
            $this->userModel = new UserModel();
            $userInSession = session()->get('user');
            $this->userInDB = $this->userModel->getUserByEmail($userInSession['email']);


        }


        private function addDateIfPossible( $groupID){

            $out = "";

            // new sent msg case
            $lastDate = $this->msgModel->getLastSentDate($groupID);

            $hasMsgs = $this->groupModel->hasMsgs($groupID);


            // $out = "$lastDate";

            if( 
                $lastDate != date('Y-m-d') || 
                ! $hasMsgs
            ){

                $out .= view(
                    "VChat/ChatAreaView/MsgDateView/MsgDateView", 
                    array(
                        "date" => date('Y-m-d')
                    )
                );

            }

            return $out;

        }

      
        public function add(){

            //check group existence
            $group = session()->get('group');

            if(!$group){
                return $this->response->setJSON(
                    array( 'alert' => 'please select a group')
                );
            }

            $msg = $this->request->getPost(index: 'msg');

            // check before adding msg
            $htmlMSG = $this->addDateIfPossible($group['id']);

            $msgID = $this->msgModel->add($msg,  $group['id']);


            if($msgID == false){
                return $this->response->setJSON(
                    array( 'error' => 'an error acquired while sending you msg')
                );
            }

            // $htmlMSG .= '<br>' .$group['id'];
            
            $htmlMSG .= view(
                "VChat/ChatAreaView/RightMsgView/RightMsgView", 
                array(
                    "body"          => $msg,
                    "date"          => date("Y-m-d"),
                    "index"         => $msgID,
                    "autoScroll"    => true,
                )
            );

            // echo $data;
            return $this->response->setJSON(
                array( 
                    'html' => $htmlMSG,
                )
            );
           
        }


        public function update(){
            echo "update msg";
        }


        public function get(){
            echo "get msg";
        }


        private function getDateToRemoveID( $groupID){

            $out = "";

            $lastDate = $this->msgModel->getLastSentDate($groupID);

            // $out = "$lastDate";

            $now = date('Y-m-d');

            if( $lastDate != $now ){

                $out .= "MDV$now";

            }

            return $out;

        }


        public function remove(){

            try{

                // check group existence
                $group = session()->get(key: 'group');

                if(!$group){
                    return $this->response->setJSON(
                        array( 
                            'alert' => 'an error acquired while deleting group message'
                        )
                    );
                }
                

                $msgID = $this->request->getPost(index: 'id');


                if(!ctype_digit( $msgID)){ // expected a digit
                    return $this->response->setJSON(
                        array( 
                            'alert' => "an error acquired while posting data"
                        )
                    );
                }

                $sender = $this->msgModel->getSender($msgID);

                $admin = $this->groupModel->getCreator($group['id']);

  
                // only current use and admin are able to delete msg
                $isCurrentUser = $this->userInDB['id'] == $sender['id'];
                $isAdmin = $this->userInDB['id'] == $admin['id'];


                if(!($isCurrentUser || $isAdmin)){
                    return $this->response->setJSON(
                        array( 'error' => "you can't remove this msg")
                    );
                }
            
                $status = $this->msgModel->remove($msgID,  groupID: $group['id']);

                if(!$status){
                    return $this->response->setJSON(
                        array( 'error' => 'an error acquired while sending you msg')
                    );
                }

                $divID = $this->getDateToRemoveID($group['id']);

                if($divID){

                    return $this->response->setJSON(
                        array( 'remove' => $divID)
                    );

                }else{

                    return $this->response->setJSON(
                        array( 'msg' => "success  $status")
                    );
                }

            }catch(Exception $e){

                return $this->response->setJSON(
                    array( 'msg' => "MY ERROR Handler: " . $e->getMessage())
                );

            }

        }
        
    }

?>