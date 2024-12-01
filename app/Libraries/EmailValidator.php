<?

    namespace App\Libraries;

    use Exception;
    
    
    class EmailValidator{
        

        public function sendEmail($receiver, $subject, $message){

            try{

                $email = service("email");
                $email->setFrom(env("SMTP_USER"), 'GroupCollab CEO');
                $email->setTo($receiver);
                $email->setSubject($subject);
                $email->setMessage($message);
    
                // Send the email
                if (!$email->send()) {
                    // if there was an error here, make sure to enable "less secure app access"
                    throw new Exception(
                        "Email Error: <br>". $email->printDebugger()
                    );
                }

                return true;

            }catch(Exception $e){

                echo $e->getMessage();

            }
          
        }


        public function getRandInts($length) {
            $out = '';
            for ($i = 0; $i < $length; $i++) {
                $randomDigit = rand(0, 9);
                $out .= $randomDigit;
            }
            return $out;
        }

    }














?>