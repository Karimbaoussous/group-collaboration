<?php   

    namespace App\Controllers;

    use App\Models\GroupModel;
    use App\Models\UserModel;

    class Img extends BaseController{


        private $groupModel, $userModel, $keys = ["group", "user"];

        public function __construct(){

            $this->groupModel = new GroupModel();
            $this->userModel = new UserModel();

        }
        

        public function getLink($id, $modelName): string{


            $sessionID = session()->session_id;
            $userInSession = session()->get($sessionID);
            $imgsLink = $userInSession? $userInSession['imgsLink']: array();

            $link = base_url("img/");

            $formula = $modelName . '_' . $id;

            // $link .=   $formula;

            $index = array_search(  needle: $formula,  haystack: $imgsLink);

            if ($index !== false) {// exists

                $link .= $index;

            }else{

                $imgsLink[] = $formula;
                $link .= sizeof(value: $imgsLink) - 1;

            }

            $userInSession['imgsLink'] = $imgsLink;
            session()->set($sessionID, $userInSession);

            return $link;

        }
        
        
        public function setLinks(
            $table, $att1 = "image", $id = "id", $modelName
        ){

            for($i = 0; $i< sizeof(value: $table); $i++){ 
                $table[$i][$att1] = $this->getLink( 
                    $table[$i][$id] ,
                    $modelName
                );
            }
            return $table;

        }

        
        public function display($index){

            $sessionID = session()->session_id;
            $userInSession = session()->get( $sessionID);

            if(!isset($userInSession['imgsLink'])){
                echo "login first";
                return;
            }

            $imgsLink = $userInSession['imgsLink'];

          
            $formula = $imgsLink[$index];

            if ($formula) {

                $randomName = uniqid(rand(), true);

                $img = null;

                if(strpos($formula, "group") !== false){

                    $id = str_replace("group_", "", $formula);
                    $img = $this->groupModel->getImg($id);

                }else if(strpos($formula, "user") !== false){

                    $id = str_replace( 
                        "user_", "", $formula
                    );

                    $img = $this->userModel->getImg($id);

                }
// 
                // echo "forme  $formula";
                // echo " <br> <br> $img";

                return $this->response->download(
                    filename: $randomName .".webp",
                    data: $img
                );

            } else {
                return $this->response->setStatusCode(404, 'Image not found');
            }

        } 

    }

?>