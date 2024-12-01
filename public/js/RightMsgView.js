


function handleRightMsgContainerMouseEnter(rightMsgContainer){

    // console.log("debug")

    const optionsContainer = document.createElement("div");

    optionsContainer.style.cssText = `
        display: flex;
        order: 0;
        flex-direction: row-reverse;
        align-items: center;
        justify-content: center;

        gap: var(--gap-h);
    `;

    const moreBtn = document.createElement("div");
    const btnsContainer = document.createElement('div');

    moreBtn.innerText = "..."
    moreBtn.classList.add("moreBtn");
    
    moreBtn.onmouseenter = ()=>{

        const divContainer = rightMsgContainer.parentElement
                
        btnsContainer.innerHTML = `
            <div class="optionsBtn" onclick="removeMsg('${divContainer.id}')">
                remove 
            <div>
        `;

        optionsContainer.appendChild(btnsContainer);

    }

    optionsContainer.onmouseleave = ()=>{
        btnsContainer.remove()
    }

    optionsContainer.appendChild(moreBtn)

    rightMsgContainer.appendChild(optionsContainer);

}


function handleRightMsgContainerMouseLeave(rightMsgContainer){

    // console.log(rightMsgContainer)

    if(rightMsgContainer.children.length  != 2) {
        console.warn("right msg must have 2 children's otherwise it may generate an error");
        return 
    }

    const optionsContainer = rightMsgContainer.children[1];

    if(optionsContainer.children.length > 0){

        const moreBtn = optionsContainer.children[0];
        moreBtn.remove()
        optionsContainer.remove()

    }

    
}


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
        alert(data['error']);
        return;
    }else if("remove" in data){

        document.getElementById(data['remove']).remove()
        
    }else  if("alert" in data){
        alert(data['alert']);
        return;
    }else if("msg" in data){
        console.log(data['msg']);
    }

   document.getElementById(containerID).remove();

}

