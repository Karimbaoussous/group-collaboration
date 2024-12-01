
async function handleJoinChatBtnClick(groupID){


    const chatViewLeft = document.getElementById('chatViewLeft');
    const chatViewLeftMain = document.getElementById('chatViewLeftMain');
    const chatViewLeftAside = document.getElementById('chatViewLeftAside');

    const formData = new FormData();

    formData.append("id", groupID);

    const response = await fetch("/group/join", {
        method: 'post',
        body: formData,
        credentials: 'include', // Enables session
    })

    if(!response.ok){
        console.log("not ok response");
    }

    const data = await response.json();

    if ("msg" in data){
        console.log(data['msg'])
    }

    if("error" in data){
        console.error(data['error'])
        return;
    }else  if("alert" in data){
        alert(data['alert'])
        return;
    }else if("html" in data){

        // remove join msg
        const JoinChatView = document.getElementById("JoinChatView");
        JoinChatView.remove();

        chatViewLeftMain.innerHTML = data['html']

    }

    
    scrollToLastMsg();


    if(chatViewLeft.classList.contains('four')){

        // remove aside
        chatViewLeftAside.innerHTML = ""
        // remove style that display's it
        chatViewLeft.classList.remove('four');

    }

}





function handleJoinChatRemoveBtnClick(){

    const container = document.getElementById("JoinChatView");
    container.remove()

}

