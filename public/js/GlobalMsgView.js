

async function removeMsg(containerID){

    // console.log(containerID)
    
    const formData = new FormData();

    let msgID = String(containerID);
    if(msgID.includes('rightMsgContainer')){
        msgID =  msgID.replaceAll('rightMsgContainer', "")
    }else if(msgID.includes('leftMsgContainer')){
        msgID = msgID.replaceAll('leftMsgContainer', "")
    }else{
        throw new Error("invalid msg ID " + msgID)
    }
   
    formData.append('id', msgID);

    // console.log("id", id)

    const response = await fetch("/msg/remove", {
        method: 'post',
        body: formData,
        credentials: 'include', // Enables session
    })

    // console.log("id", id)

    const data = await response.json();

    if("error" in data){
        console.error(data['error']);
        return;
    }else if("remove" in data){

        document.getElementById(data['remove']).remove()
        
    }else  if("alert" in data){
        alert(data['alert']);
        return;
    }else if("msg" in data){
        console.log(data['msg']);
        return;
    }

    // remove msg
    document.getElementById(containerID).remove();

}



async function updateMsg(containerID){

    let msgID = String(containerID);
    if(msgID.includes('rightMsgContainer')){
        msgID =  msgID.replaceAll('rightMsgContainer', "")
    }else if(msgID.includes('leftMsgContainer')){
        msgID = msgID.replaceAll('leftMsgContainer', "")
    }else{
        throw new Error("invalid msg ID " + msgID)
    }


    // console.log(containerID)
    // console.log(msgID)


    const msgContainer = document.getElementById(containerID);
    const msgDiv = msgContainer.querySelector(".content")
    const msg = msgDiv.innerText;

    // console.log(msg)

    const msgInputViewMsg = document.getElementById("msgInputViewMsg");
    msgInputViewMsg.value = msg

    const msgInputViewBtns = document.getElementById('msgInputViewBtns');
    msgInputViewBtns.innerHTML = "";

    const confirmBtn = new IconBtn(serverIP + "icons/mark.png", "4dvh")
    confirmBtn.appendStyle(`
        background: var(--white); 
        border-radius: 25%; padding: 
        var(--padding-h);    
    `)
    confirmBtn.onclick = ()=>{

        handleConfirmMsgUpdate(containerID);

    }
    confirmBtn.display(msgInputViewBtns)

    
    const cancelBtn = new IconBtn(serverIP + "icons/cancel.png", "4dvh")
    cancelBtn.appendStyle(` 
        background: var(--white); 
        border-radius: 25%; padding: 
        var(--padding-h);   
    `)
    cancelBtn.onclick = handleCancelMsgUpdate;
    cancelBtn.display(msgInputViewBtns)

}


async  function handleConfirmMsgUpdate(containerID){

    // console.log("handleConfirmMsgUpdate", containerID);

    let msgID = String(containerID);

    if(msgID.includes('rightMsgContainer')){
        msgID =  msgID.replaceAll('rightMsgContainer', "")
    }else if(msgID.includes('leftMsgContainer')){
        msgID = msgID.replaceAll('leftMsgContainer', "")
    }else{
        throw new Error("invalid msg ID " + msgID)
    }

    // console.log(msgID)


    const msgInputViewMsg = document.getElementById("msgInputViewMsg");

    const formData = new FormData();

    if(String(msgInputViewMsg.value).trim().length <= 0){
        alert("please type something");
        return;
    }

    formData.append('id', msgID);
    formData.append('content', msgInputViewMsg.value);

    // console.log("id", id)

    const response = await fetch("/msg/update", {
        method: 'post',
        body: formData,
        credentials: 'include', // Enables session
    })

    // console.log("id", id)

    const data = await response.json();

    if("error" in data){
        alert(data['error']);
        return;
    }else  if("alert" in data){
        alert(data['alert']);
        return;
    }else if("msg" in data){
        console.log(data['msg']);
        return;
    }else if("success" in data){

        console.log(data['success']);

        const msgContainer = document.getElementById(containerID);
        const msgDiv = msgContainer.querySelector(".content")
        msgDiv.innerText = msgInputViewMsg.value;

        // reset ui
        handleCancelMsgUpdate();
    
        return;
    }



  

}


function handleCancelMsgUpdate(){

    // console.log("handleCancelMsgUpdate")
    
    const msgInputViewBtns = document.getElementById('msgInputViewBtns');

    msgInputViewBtns.innerHTML = "";

    const sentBtn = new IconBtn(serverIP + "icons/send.png", "4dvh")
    sentBtn.appendStyle(`
        background: var(--white); 
        border-radius: 25%; padding: 
        var(--padding-h);      
    `)
    sentBtn.onclick = handleSendMsgBtnClick;
    sentBtn.display(msgInputViewBtns)

    document.getElementById("msgInputViewMsg").value = "";


}