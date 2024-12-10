

async function handleGroupInfosClick(groupID){

    const chatViewLeft = document.getElementById('chatViewLeft');
    const chatViewLeftAside = document.getElementById('chatViewLeftAside');

    if(chatViewLeft.classList.contains("forMembers")){

        // i must make a backend function to prevent this later
        console.log("maybe group members view is already opened");
        return;

    }
        
    const formData = new FormData();

    formData.append('id', groupID);

    const response = await fetch("/member/load", {
        method: 'post',
        body: formData,
        credentials: 'include', // Enables session
    })

    if(!response.ok){
        console.log("not ok response");
    }

    const data = await response.json();

    if("error" in data){
        alert(data['error'])
        return false;
    }else if ("msg" in data){
        console.log(data['msg'])
        return false;
    }else if("html" in data){
        
        // display members area
        chatViewLeft.classList.add("four"); // add style
        chatViewLeft.classList.add("forMembers"); // add style

        chatViewLeftAside.innerHTML = data['html']

        return true;
        
    }

    // const chatViewLeft = document.getElementById('chatViewLeft');
    // chatViewLeft.innerHTML += ;

}

