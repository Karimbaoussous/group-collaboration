

function handleRemoveGroupMembersView(){

    const chatViewLeft = document.getElementById('chatViewLeft');
    const chatViewLeftAside = document.getElementById('chatViewLeftAside');
    
    if(chatViewLeft.classList.contains('four')){

        // remove aside
        chatViewLeftAside.innerHTML = ""
        // remove style that display's it
        chatViewLeft.classList.remove('four');

    }

    if(chatViewLeft.classList.contains("forMembers")){

        chatViewLeft.classList.remove('forMembers');

    }

}


async function handleGroupMembersSearch(searchValue){

    // console.log("handleGroupMembersSearch")

    const formData = new FormData();

    formData.append('search', searchValue);

    try {

        const response = await fetch("/member/search", {
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
            alert(data['error'])
            return false;
        }else if ("msg" in data){
            console.log(data['msg'])
            return false;
        }else if("html" in data){
    
            // console.log(data['html'])
    
            const groupMembers = document.getElementById('groupMembers');
            groupMembers.innerHTML = data['html']
            const membersNumber = document.getElementById('membersNumber');
            membersNumber.innerHTML = data['membersNumber'] + " Members";
    
            return true;
            
        }
        
    } catch (error) {

        console.error(error);
        
    }



}
