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
                        "redirect" => 'signUp/'
                    )
                );
            
            }

         
            $randomInts =$this->emailVal->getRandInts(4);

    
            $status = $this->emailVal->sendEmail( 
                $user["email"], 
                "Changing Password validation",
                $randomInts
            );

            // echo   $status ."<br>";


            $user["code"] = $randomInts;

            session()->set( "user",  value: $user);

            return view("VConfirm/ConfirmView",
                array(
                    "action"    => '/forgot/confirmation',
                    "title"     => 'Password Validation'
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

            $code = "$num1$num2$num3$num4";

            // load validation data
            $user = session()->get("user");
            
            if( $code == $user["code"]){

                // clear session for security reasons
                session()->remove(key: "user");

                // save data in session
                session()->set("user",
                    array(
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
                        "redirect" => "/forgot/confirmation"
                    )
                );

            }


        }


        public function change(){

            $user = session()->get(key: "user");

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
                'CNewPassword'   => 'required|max_length[255]|min_length[1]',
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
            session()->remove(key: "user");

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