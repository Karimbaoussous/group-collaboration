
<style>

    .chatAreaView{

        display: flex;
        flex-direction: column;

        background-color: var(--black-10);
        color: var(--white);
        padding: var(--padding-h);

        overflow-y: auto;
        gap: var(--gap-h);

    }

    .chatAreaView .greeting{

        align-self: center;

    }


</style>


<?php 

    // create elements to test
    $msgs = [];

 
    function test(){

        $localMsgs = [];

        for($i=0; $i< 100;$i++){

            $content = "";
            for($j=0; $j< $i +1;$j++){
                if($i %2 == 0){
                    $content .= " content" ;
                }else if($i % 3 == 0){
                    $content .= " تعشيت قبل الماطش الحمد الله" ;
                }else{
                    $content .= "content";
                }
               
            }
           
            $localMsgs[$i] = array(
                "id" => $i,
                "src" => base_url("imgs/img.png"),
                "name" => "group $i",
                "body" => $content,
                "isRight" => $i%2 == 0,
                "date" => date("Y-m-d")
            );
        }

        return $localMsgs;
    
    }

    // $msgs = test();
    
    if(isset($listOfMsgs)){
        $msgs = array_merge($msgs, esc($listOfMsgs));
    }

?>



<main class="chatAreaView" id="chatAreaView">

    

    <? 

        function toValidDate($date){
            return (new Datetime($date))->format('Y-m-d');
        }


        //sort msg by date
        usort(
            $msgs, 
            function ($a, $b) {
                return strtotime($a['date']) - strtotime(datetime: $b['date']);
            }
        );


        $oldDate =  '';

        for($i = 0; $i < sizeof(value: $msgs); $i++){

            $msg = $msgs[$i];

            $msg['index'] = $msg['id'];
            $msg['date'] = toValidDate($msg['date']);

            // display unique date at the top only
            if( $msg['date'] != $oldDate){
                echo view("VChat/ChatAreaView/MsgDateView/MsgDateView", data: $msg);
                $oldDate = $msg['date'];
            }

            if($msg["isRight"] == "right"){

                echo view("VChat/ChatAreaView/RightMsgView/RightMsgView", data: $msg);
            
            }else{

                echo view("VChat/ChatAreaView/LeftMsgView/LeftMsgView", data: $msg);

            }

        } 

        $greetings = [
            "Hello", "Hi", "Hey", "Howdy", "What's up?",
            "Bonjour", "Hola", "Ciao", /* Italian*/"Namaste", /*Hindi*/
            "Salam",   /* Arabic*/ "Konnichiwa" // Japanese
        ];

        //ge ta random greeting
        $greeting = $greetings[
            random_int(0, sizeof($greetings)-1)
        ];

        if(empty($msgs)){
            echo "
            <center id='greeting'> 
                Be the first to say <strong>$greeting!</strong>
            </center>
            ";
        }

    ?>

</main>


<script>


    function scrollToLastMsg() {

        const container = document.getElementById("chatAreaView");
      
        let lastMessage = container.children[container.children.length - 2];

        if(!lastMessage) return

        lastMessage.scrollIntoView({ 
            behavior: "smooth", 
            block: "end"
        });

        // console.log(lastMessage);

    }

    scrollToLastMsg()


</script>

