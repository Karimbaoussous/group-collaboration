<?php  

    namespace App\Controllers;

    use App\Models\UserModel;
    use Exception;

    use App\Libraries\EmailValidator;


    class SignUp extends BaseController {  


        protected $emailVal, $userModel;

        function __construct(){

            // Include helpers
            helper('form');
    
            // Assign EmailValidator to the class property
            $this->emailVal = new EmailValidator();
            $this->userModel = model(UserModel::class);

        }


        public function index()  { 
        
            $user = session()->get("user");

            if($user && $user["loggedIn"]){

                return redirect()->to('/chat');

            }else{

                return view('VSignUp/signUpView');  
    
            }
          
        }


        public function validation(){

            $data = $this->request->getPost([
                'username', 'email', 'password', 'cPassword'
            ]);

            // Checks whether the submitted data passed the validation rules.
            if (! $this->validateData($data, [
                'username'      => 'required|max_length[255]|min_length[1]',
                'email'         => 'required|max_length[255]|min_length[1]',
                'password'      => 'required|max_length[255]|min_length[1]',
                'cPassword'     => 'required|max_length[255]|min_length[1]',
            ])) {
                return $this->index(); // The validation fails, so return to login.php
            }

            // Gets the validated data. (posted data)
            $user = $this->validator->getValidated();
    
        
            // check if email is duplicated or not
            if($this->userModel->checkEmailExistence($user['email'])){
                return view(
                    "Global/alert", 
                    array(
                        "msg" => "email already exist",
                        // "redirect" => "signUp/"
                    )
                ).
                $this->index(); // return to login.php
            }


            $randomInts =$this->emailVal->getRandInts(4);

            $this->emailVal->sendEmail( 
                $user["email"], 
                "Sign up confirmation",
                $randomInts
            );

            $user["code"] = $randomInts;
            session()->set("user", $user);
            

            return view("VConfirm/ConfirmView", array( 
                "action" => "/signUp/confirmation",
                "title" => "Sign up"
            ));


        }


        // confirm sign up by sending a code to user gmail
        public function confirmation(){

            $data = $this->request->getPost([
                'number1', 'number2', 'number3', 'number4'
            ]);

            // Checks whether the submitted data passed the validation rules.
            if (! $this->validateData($data, [
                'number1'   => 'required|max_length[1]|min_length[1]',
                'number2'   => 'required|max_length[1]|min_length[1]',
                'number3'   => 'required|max_length[1]|min_length[1]',
                'number4'   => 'required|max_length[1]|min_length[1]',
            ])) {
                return view("VConfirmSingUp/ConfirmSignUp");
            }

            // Gets the validated data. (posted data)
            $post = $this->validator->getValidated();

            $num1 = $post['number1'];
            $num2 = $post['number2'];
            $num3 = $post['number3'];
            $num4 = $post['number4'];

            $code = "$num1$num2$num3$num4";

            // load validation data
            $user = session()->get("user");
            
            if( $code == $user["code"]){
                
                // add user and check if added

                if(!$this->userModel->add($user)){
                    return view(
                        "Global/alert",
                        array(
                            "msg" => "failed to add user",
                            // "redirect" => "signUp/"
                        )
                    ).
                    $this->index(); // return to login.php
                }

                // clear session for security reasons
                session()->remove("user");

                // save data in session
                session()->set("user",
                    array(
                        "fname"     => null,
                        "lname"     => null,
                        "email"     => $user["email"],
                        "username"  => $user["username"],
                        "loggedIn"  => true
                    )
                );

                // go to chat
                return redirect()->to('chat/');

            }else{

                return view(
                    "Global/alert",
                    array(
                        "msg" => "The code is incorrect",
                        // "redirect" => "signUp/"
                    )
                );

            }


        }

    }

?>