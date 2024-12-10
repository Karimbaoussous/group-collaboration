<?

    namespace App\Controllers;

    use App\Libraries\EmailValidator;
    use App\Models\UserModel;


    class ForgotPassword extends BaseController {
        
        protected $emailVal, $userModel;


        // constructeur
        function __construct(){

            // include  libs and helpers
            helper('form');
            $this->emailVal = new EmailValidator();
            $this->userModel = model(UserModel::class);

        }


        // forgot password
        public function index(){
            return view(name: "VForgotPassword/forgotPasswordView");
        }


        public function validation(){

            $user = $this->request->getPost(['email']);

            $rules = [
                'email' => 'required|max_length[255]|min_length[1]',
            ];

            // Checks whether the submitted data passed the validation rules.
            if(! $this->validateData($user, $rules)) {
                return $this->index(); // The validation fails, so return to login.php
            }

            // Gets the validated data. (posted data)
            $user = $this->validator->getValidated();

            // check if email doesn't exist
            if(!$this->userModel->checkEmailExistence($user['email'])){

                return view(
                    "Global/alert", 
                    array(
                        "msg" => "email doesn't exist",
                        "redirect" => 'forgot/'
                    )
                );
            
            }

         
            $randomInts =$this->emailVal->getRandInts(4);

    
            $status = $this->emailVal->sendEmail( 
                $user["email"], 
                "Changing Password validation",
                $randomInts
            );

            if(gettype($status) == 'string'){

                echo $status;
                return view(
                    "Global/alert", 
                    array(
                        "msg" =>  "We cannot sent an email at the moment!",
                        "redirect" => 'login/'
                    )
                );
            
            }


            // echo   "
            //     <script>
            //         console.log('uncomment code above');
            //         console.log('$randomInts');
            //     </script>
            // ";

            $user["code"] = $randomInts;

            session()->set( data: "tempUser",  value: $user);

            return view("VConfirm/ConfirmView",
                array(
                    "action"    => '/forgot/confirmation',
                    "title"     => 'Password Validation',
                    "email" => $user["email"]
                )

            );

        }


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
                return view(name: "VConfirm/ConfirmView",
                    data: array(
                        "action"    => '/forgot/confirmation',
                        "title"     => 'Password Validation'
                    )
                );
            }

            // Gets the validated data. (posted data)
            $post = $this->validator->getValidated();

            $num1 = $post['number1'];
            $num2 = $post['number2'];
            $num3 = $post['number3'];
            $num4 = $post['number4'];

            $codeEntered = "$num1$num2$num3$num4";

            // load validation data
            $user = session()->get(key: "tempUser");

            if(!isset($user["code"])){
                
                return view(
                    "Global/alert",
                    array(
                        "msg" => "Invalid data",
                        "redirect" => "forgot/"
                    )
                );
            }
            
            if($user["code"] == $codeEntered){

                // clear session for security reasons
                session()->remove(key: "tempUser");

                // save data in session
                session()->set(
                    data: "tempUser",
                    value: array(
                        "email"     =>$user["email"],
                        "loggedIn"  => true
                    )
                );

                return view("VChangePassword/changePasswordView");

            }else{

                return view(
                    "Global/alert",
                    array(
                        "msg" => "The code is incorrect",
                        "redirect" => "forgot/"
                    )
                );

            }


        }


        public function change(){

            $user = session()->get(key: "tempUser");

            if(
                !$user || 
                ( isset($user['loggedIn'] ) && !$user['loggedIn'] ) ||
                ( isset($user['email'] ) && !$user['email'] ) 
            ){
                return view(
                    "Global/alert",
                    array(
                        "msg" => "Access denied",
                        "redirect" => "/forgot/change"
                    )
                );
            }

            $data = $this->request->getPost([
                'newPassword', 'CNewPassword'
            ]);

            // Checks whether the submitted data passed the validation rules.
            if (! $this->validateData($data, [
                'newPassword'   => 'required|max_length[255]|min_length[1]',
                'CNewPassword'   => 'required|max_length[255]|min_length[1]|matches[newPassword]',
            ])) {
                return view("VChangePassword/changePasswordView");
            }

            // Gets the validated data. (posted data)
            $post = $this->validator->getValidated();

            $password = $post['newPassword'];

            //failed to update password
            if(!$this->userModel->updatePassword($user['email'], $password)){
                return view(
                    "Global/alert",
                    array(
                        "msg" => "Cannot update your password",
                        "redirect" => ""
                    )
                );
            }

            // clear session for security reasons
            session()->remove(key: "tempUser");

            $user = $this->userModel->getUserByEmail($user["email"]);

            // save data in session
            session()->set("user",
                array(
                    "fname"     =>null,
                    "lname"     =>null,
                    "email"     =>$user["email"],
                    "username"  =>$user["username"],
                    "loggedIn"  => true
                )
            );

            return redirect()->to("chat/")->withCookies();

        }


    }
?>