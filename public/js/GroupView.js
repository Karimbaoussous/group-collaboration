



async function displayJoinGroupMsg(formData){

    const JoinChatView = document.getElementById("JoinChatView");

    if(JoinChatView){ // remove last one if exists
        JoinChatView.remove();
    }

    const chatViewLeftMain = document.getElementById('chatViewLeftMain');

    const response = await fetch("/group/join/request", {
        method: 'post',
        body: formData,
        credentials: 'include', // Enables session
    })

    if(!response.ok){
        console.log("not ok response");
    }

    const data = await response.json();

    if("error" in data){
        console.error(data['error'])
        return;
    }else  if("alert" in data){
        alert(data['alert'])
        return;
    }else if ("msg" in data){
        console.log(data['msg'])
        return;
    }else if("html" in data){

        chatViewLeftMain.innerHTML = data['html'];

    }

}


async function handleGroupClick(groupID){

    const chatViewLeft = document.getElementById('chatViewLeft');
    const chatViewLeftMain = document.getElementById('chatViewLeftMain');
    const chatViewLeftAside = document.getElementById('chatViewLeftAside');

    if(chatViewLeft.classList.contains("forMembers")){
        chatViewLeft.classList.remove("forMembers")
    }

    if(chatViewLeft.classList.contains("forGroup")){
        chatViewLeft.classList.remove("forGroup")
    }

    const formData = new FormData();

    formData.append('id', groupID);

    const response = await fetch("/group/load", {
        method: 'post',
        body: formData,
        credentials: 'include', // Enables session
    })

    if(!response.ok){
        console.log("not ok response");
        return false;
    }

    const data = await response.json();

    if("joinRequest" in data){

        console.log("joinRequest")

        await displayJoinGroupMsg(formData)
        
        if(chatViewLeft.classList.contains('four')){

            // remove aside
            chatViewLeftAside.innerHTML = ""
            // remove style that display's it
            chatViewLeft.classList.remove('four');

        }

        return false;

    }else if("error" in data){
        console.error(data['error'])
        return false;
    }else  if("alert" in data){
        alert(data['alert'])
        return false;
    }else if ("msg" in data){
        console.log(data['msg'])
        return false;
    }else if("html" in data){

        chatViewLeftMain.innerHTML = data['html']

        scrollToLastMsg();

        if(chatViewLeft.classList.contains('four')){

            // remove aside
            chatViewLeftAside.innerHTML = ""
            // remove style that display's it
            chatViewLeft.classList.remove('four');

        }

        return true;

    }


  
}


async function handleSearchGroupsViewClick(searchValue){
    

    const formData = new FormData();

    formData.append('search', searchValue);

    const response = await fetch("/group/search", {
        method: 'post',
        body: formData,
        credentials: 'include', // Enables session
    })

    if(!response.ok){
        console.log("not ok response");
        return false;
    }

    const data = await response.json();

    if("error" in data){
        console.error(data['error'])
        return false;
    }else  if("alert" in data){
        alert(data['alert'])
        return false;
    }else if ("msg" in data){
        console.log(data['msg'])
        return false;
    }else if("html" in data){

        // console.log( data['html'])
        const groupsView = document.getElementById('groupsView');

        if(groupsView){ 

            groupsView.innerHTML = data['html']
        
            // const groupsAside = document.getElementById('groupsAside');
            // groupsAside.innerHTML = data['html']
    
            const groupsNumber = document.getElementById('groupsNumber');
            groupsNumber.innerHTML = data['groupsNumber'] + " Groups";

        }else{
            console.warn("There might be an error here!")
        }
       
        return true;
        
    }

    
}
