


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


async function handleSendMsgBtnClick(){

    const msgInput = document.getElementById("msgInputViewMsg")

    const formData = new FormData();

    if(String(msgInput.value).trim().length == 0){
        alert("please type something");
        return;
    }

    formData.append('msg', msgInput.value);

    // console.log("data", msgInput.value)

    const response = await fetch("/msg/add", {
        method: 'post',
        body: formData,
        credentials: 'include', // Enables session
    })

    const data = await response.json();

    if("error" in data){
        alert(data['error'])
        return;
    }else  if("alert" in data){
        alert(data['alert'])
        return;
    }else  if("html" in data){

        // remove greetings if exists
        const greeting = document.getElementById("greeting");
        if(greeting) greeting.remove();

        const chatAreaView = document.getElementById("chatAreaView");
        chatAreaView.innerHTML += data.html

        // console.log("data received", data)

        msgInput.value = ""

        scrollToLastMsg()
      
        return;
    }

   

}

