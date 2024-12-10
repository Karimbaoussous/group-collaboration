<?php   

    namespace App\Controllers;

    use App\Libraries\GlobalC;
    use App\Models\UserModel;
    use DateTime;
    use Exception;

    
    class Profile extends BaseController{

        private $userInSession, $userModel, $userInDB, $globalClass, $imgy;


        public function __construct(){

            helper('form');

            $this->userModel = new UserModel();
            $this->userInSession = session()->get('user');
            $this->userInDB = $this->userModel->getUserByEmail($this->userInSession['email']);

            $this->globalClass = new GlobalC();

            $this->imgy = new Img();

        }


        public function index(){

            // echo "hi";

            try{

                return view("frontend/browser/index");

            }catch(Exception $e){

                return view(
                    "Global/alert", 
                    array(
                        "msg" => "Error: " . $e->getMessage(),
                        "redirect" => 'login/'
                    )
                );

            }
  

        }


        public function load(){

            try{

                //retrieve session data
                if($this->userInSession == null){
                    return $this->response->setJSON(
                        array( 'alert' =>  "you must login first" .$this->userInSession )
                    );
                }

                $this->userInDB["image"] = $this->imgy->getLink(
                    $this->userInDB["id"], 
                    "user"
                );

                // echo $data;
                return $this->response->setJSON(
                    body: array( 'user' => $this->userInDB)
                );


            }catch(Exception $e){
       
                return $this->response->setJSON(
                    array( 'error' =>  "My Error Handler: ". $e->getMessage())
                );

            }
          
        }

        
        public function updateImage(){

            try{

                //retrieve session data
                if($this->userInSession == null){
                    return $this->response->setJSON(
                        array( 'error' =>  "you must login first")
                    );
                }

                $data = $this->request->getPost(index: ['img']);

                // Checks whether the submitted data passed the validation rules.
                if (! $this->validateData($data, [
                    'img' => 'uploaded[img]|is_image[img]',
                ])) {
                    // The validation fails, so returns the form.
                    return $this->response->setJSON(
                        array( 'error' => $this->validator->getErrors())
                    );
                }
        
                // Gets the validated data.
                // $post = $this->validator->getValidated();

                $img = $this->request->getFile("img");
                
                // Get file content as binary data
                $imgData = file_get_contents(filename: $img->getTempName());

                
                $status = $this->userModel->updateImage(
                    email: $this->userInSession["email"], 
                    img: $imgData 
                );


                if(!$status){
                    return $this->response->setJSON(
                        body: array( 'alert' =>   "failed white saving profile image")
                    );
                }


                // echo $data;
                return $this->response->setJSON(
                    body: array( 'msg' =>   $status)
                );


            }catch(Exception $e){
       
                return $this->response->setJSON(
                    array( 'error' =>  "My Error Handler: ". $e->getMessage())
                );

            }
          
        }


        public function update(){

            try{

                //retrieve session data
                if($this->userInSession == null){
                    return $this->response->setJSON(
                        array( 
                            'error' =>  "An error was acquired while updating you data"
                            )
                    );
                }

                $keys = [
                    'username', 'about', 'phone', "contactEmail",
                    "link1", "link2", "link3", "link4",
                    "fname", "lname", "born"
                ];

                // password, confirm password
                $data = $this->request->getPost(index: $keys);

                // Checks whether the submitted data passed the validation rules.
                if (! $this->validateData($data, [
                    'username' => 'required|max_length[100]|min_length[1]',
                    "contactEmail" => 'max_length[100]',
                    'about' => 'max_length[255]',
                    'phone' => 'max_length[15]|min_length[10]',
                    'link1' => 'max_length[255]',
                    'link2' => 'max_length[255]',
                    'link3' => 'max_length[255]',
                    'link4' => 'max_length[255]',
                    'fname' => 'max_length[50]',
                    'lname' => 'max_length[50]',
                    "born" => "valid_date[Y-m-d]"
                ])) {

                    $error = "";
                    foreach($keys as $key){
                        if(isset($this->validator->getErrors()[$key])){
                            $error .= $this->validator->getErrors()[$key] . "\n";
                        }
                    }
                   
                    // The validation fails, so returns the form.
                    return $this->response->setJSON(
                        array( 'alert' => $error)
                    );

                }
        
                // Gets the validated data.
                $post = $this->validator->getValidated();

                $now = new DateTime(date("Y-m-d"));
                $born = new DateTime($post['born']);

                if($now <= $born){
                    return $this->response->setJSON(
                        body: array( 'alert' => "incorrect born date")
                    ); 
                }

                $error = $this->userModel->updateProfile(
                    $post, $this->userInSession['email']
                );

                if(gettype(value: $error) == "string"){
                    return $this->response->setJSON(
                        body: array( 'alert' =>   $error)
                    );    
                }

                session()->set("user", [
                    "fname"     => $post["fname"],
                    "lname"     => $post["lname"],
                    "email"     => $this->userInSession["email"],
                    "username"  => $post["username"],
                    "loggedIn"  => true
                ]);

                $this->userInSession = session()->get("user");
        
                // echo $data;
                return $this->response->setJSON(
                    body: array( 'status' =>  1)
                );


            }catch(Exception $e){
       
                return $this->response->setJSON(
                    array( 'error' =>  "My Error Handler: ". $e->getMessage())
                );

            }
          
        }


        public function remove(){

            try{

                //retrieve session data
                if($this->userInSession == null){
                    return $this->response->setJSON(
                    array( 
                        'alert' =>  "An error was acquired while deleting you data"
                        )
                    );
                }

                $keys = ["email"];
                // password, confirm password
                $data = $this->request->getPost(index: $keys);

                // Checks whether the submitted data passed the validation rules.
                if (! $this->validateData($data, [
                    "email" => 'valid_email|max_length[100]|min_length[4]',
                ])) {

                    $error = "";
                    foreach($keys as $key){
                        if(isset($this->validator->getErrors()[$key])){
                            $error .= $this->validator->getErrors()[$key] . "\n";
                        }
                    }
                   
                    // The validation fails, so returns the form.
                    return $this->response->setJSON(
                        array( 'alert' => $error)
                    );

                }
        
                // Gets the validated data.
                $post = $this->validator->getValidated();

                $error = $this->userModel->remove($post['email']);

                // return $this->response->setJSON(
                //     body: array( 'msg' =>  $error)
                // );

                session()->destroy();
                $this->userInSession = null;

                if(gettype($error) == "string"){

                    return $this->response->setJSON(
                        body: array( 'msg' =>  $error)
                    );

                }
                
                return $this->response->setJSON(
                    body: array( 'success' =>  "ok")
                );


            }catch(Exception $e){
       
                return $this->response->setJSON(
                    array( 'error' =>  "My Error Handler: ". $e->getMessage())
                );

            }
          
        }


    }

?>