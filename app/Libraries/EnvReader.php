<?

    namespace App\Libraries;

    class EnvReader{

        private $path;

        public function __construct($params){

            $this->path = $params['path'];

        }

        private function removeHiddenChars($str){
            $out = "";
            for($i=0; $i < strlen($str);$i++){
                $char = $str[$i];
                // check ascii number of char
                if(ord($char) != 0){
                    $out .= $char;
                }
            }
            return $out;
        }


        function read(){

            $out = array();
            $envX = file_get_contents($this->path);
            $lines = explode("\n",$envX);

            foreach($lines as $line){
                preg_match("/([^#]+)\=(.*)/",$line,$matches);
                if(isset($matches[2])){
                    putenv(trim($line));
                    $keyValue = explode("=", $line);
                    $out[$this->removeHiddenChars($keyValue[0])] = $this->removeHiddenChars($keyValue[1]);
                }
            } 

            return $out;

        }

    }

?>