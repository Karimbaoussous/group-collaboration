<?php

    namespace App\Controllers;

    use App\Libraries\EmailValidator;
    use App\Models\UserModel;
    use Exception;

    class Login extends BaseController {

        protected $emailVal;

        
        function __construct() {

            helper('form');

            $this->emailVal = new EmailValidator();

        }
    

        // Login
        public function index() {

            $user = session()->get("user");

            if($user && $user["loggedIn"]){

                return redirect()->to('/chat');

            }else{
                return  (
                    // view('Global/header').
                    view('VLogin/loginView').
                    view('Global/footer')
                );
            }

          

        }


        public function validation() {

            $data = $this->request->getPost(['email', 'password']);

            // Validate submitted data
            if (!$this->validateData($data, [
                'email'     => 'required|min_length[1]|max_length[255]',
                'password'  => 'required|min_length[1]|max_length[255]',
            ])) {
                return redirect()->to('login/')->withCookies();;
            }

            // Extract validated data
            $email = $data['email'];
            $password = $data['password'];

            $userModel = model(UserModel::class);
            $user = $userModel->checkLogin($email, $password);

            if ($user == null) {

                return view("Global/alert", [
                    "msg" => 'Invalid email or password',
                    "redirect" => "login/"
                ]);

            } else {

                // Save user info in session
                session()->set("user", [
                    "fname"     => $user["fname"],
                    "lname"     => $user["lname"],
                    "email"     => $user["email"],
                    "username"  => $user["username"],
                    "loggedIn"  => true
                ]);


                // Redirect to chat
                return redirect()->to('chat/')->withCookies();;

            }

        }


        // Logout
        public function logout() {

            // Destroy session
            session()->destroy();

            // Redirect to login page with cookies
            return redirect()->to(uri: "/login")->withCookies();

        }
        
        
    }


?>