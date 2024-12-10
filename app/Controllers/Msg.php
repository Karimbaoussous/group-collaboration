<?php   

    namespace App\Controllers;

    use App\Models\GroupModel;
    use App\Models\MsgModel;
    use App\Models\SendModel;
use App\Models\UserModel;
use Exception;

    class Msg extends BaseController{


        private $msgModel, $userModel, $userInDB, $groupModel, $sendModel;

        public function __construct(){

            $this->groupModel = new GroupModel();
            $this->msgModel =  new MsgModel();
            $this->userModel = new UserModel();
            $this->sendModel = new SendModel();
            $userInSession = session()->get('user');

            if(!$userInSession){
                throw new Exception("Something went wrong, You must login again!");
            }

            $this->userInDB = $this->userModel->getUserByEmail($userInSession['email']);


        }


        private function addDateIfPossible( $groupID){

            $out = "";

            // new sent msg case
            $lastDate = $this->msgModel->getLastSentDate($groupID);

            $hasMsgs = $this->groupModel->hasMsgs($groupID);

            // $out = "$lastDate - $hasMsgs";
            // return $out;

            if( 
                $lastDate != date('Y-m-d') || 
                !$hasMsgs
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

            if( strlen(string: trim($msg) ) <= 0 ){
                return $this->response->setJSON(
                    array( 
                        'error' => 'please type something'
                    )
                );
            }

            // check before adding msg
            $htmlMSG = $this->addDateIfPossible($group['id']);

            // return $this->response->setJSON(
            //     array( 
            //         'msg' => "hi - " . $group['id']
            //     )
            // );

            $msgID = $this->msgModel->add($msg,  $group['id']);

            // return $this->response->setJSON(
            //     array( 
            //         'msg' => "hi - " . $group['id']
            //     )
            // );


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
                    "time"          => date("h:i A"),
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

            //check group existence
            $group = session()->get(key: 'group');

            if(!$group){
                return $this->response->setJSON(
                    array( 'alert' => 'please select a group')
                );
            }

            
            if(!$this->userInDB){
                return $this->response->setJSON(
                    array( 'alert' => 'please login')
                );
            }

        

            $msgID = $this->request->getPost(index: 'id');
            $msg = $this->request->getPost(index: 'content');

            if(strlen(trim($msg)) <= 0){
                return $this->response->setJSON(
                    array( 'alert' => 'please type something')
                );
            }

            // return $this->response->setJSON(
            //     array( 
            //         'msg' => "$msg - $msgID - " . $group['id']
            //     )
            // );


            $senderID = $this->sendModel->getSenderIdByMsgID( $msgID);

            if(!$senderID){
                return $this->response->setJSON(
                    array('error' => "An error acquired while updating you msg")
                );
            }

            if($senderID != $this->userInDB['id']){
                return $this->response->setJSON(
                    array('error' => "You are not allowed to delete this message")
                );
            }


            $error = $this->msgModel->updateMsg( $msgID,  $msg);


            if(gettype($error) == 'string'){
                return $this->response->setJSON(
                    array('error' => $error)
                );
            }


            return $this->response->setJSON(
                array( 
                    'success' => true,
                )
            );
           
        }



        private function getDateToRemoveID( $groupID, $msgID){

            $out = "";

            $status = $this->groupModel->isItLastMsgInThatDay($groupID, $msgID);

            // return $status;

            if($status){

                $date =  $this->msgModel->getSentDate($groupID, $msgID);

                $out .= "MDV$date";

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

                // this must be called before removing a msg
                $divID = $this->getDateToRemoveID($group['id'], $msgID);

                // return $this->response->setJSON(
                //     array( 'msg' => $divID)
                // );

                $status = $this->msgModel->remove($msgID,  groupID: $group['id']);

                if(!$status){
                    return $this->response->setJSON(
                        array( 'error' => 'an error acquired while sending you msg')
                    );
                }
            
                if($divID){

                    return $this->response->setJSON(
                        array( 'remove' => $divID)
                    );

                }else{

                    return $this->response->setJSON(
                        array( 'status' => "success  $status")
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