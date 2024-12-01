<?

    namespace App\Libraries;

    use App\Models\UserModel;
use CodeIgniter\HTTP\Response;

    class MyCookie{

        protected $token;


        public function __construct($tokenName){

            $this->token = $tokenName;
            helper("cookie");

        }


        public function get() {

            if(!$this->hasToken()) {
                echo "no cookie";
                return false;
            }

            $rememberMe = get_cookie($this->token);

            if (!$rememberMe) {
                echo "no token";
                return false;
            }

            $userEmail =  base64_decode($rememberMe);

            echo "remember me: ". $rememberMe . "<br><br>";
            echo "userEmail: ". $userEmail . "<br><br>";

            $model = new UserModel();
            $user = $model->getUserByEmail(email: $userEmail);
            if (!$user) {
                echo "no user <br><br>";
                return false;
            }

            // Save data in session
            session()->set("user", [
                "fname"     => $user["fname"],
                "lname"     => $user["lname"],
                "email"     => $user["email"],
                "username"  => $user["username"],
                "loggedIn"  => true
            ]);

            return true;

        }


        public function set($user) {

            // echo "<br>rememberMe: $this->token<br>";

            // Set the cookie in the response
            set_cookie(   
                $this->token,
                base64_encode($user['email']),
                86400 * 30 // 30 days
            ); 

            // echo $this->hasToken()? "token save":  "token unsaved";
            // echo $this->get();

        }

        
        public function delete(){

            // Set your cookie
            set_cookie([
                'name'   => $this->token,
                'value'  => '',
                'expire' => -1, // 1 hour
            ]);

            delete_cookie($this->token);

 
        }
        public function hasToken() {
            return has_cookie($this->token);
        }

    }