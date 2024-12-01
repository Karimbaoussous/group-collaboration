

function handleRemoveGroupMembersView(){

    const chatViewLeft = document.getElementById('chatViewLeft');
    const chatViewLeftAside = document.getElementById('chatViewLeftAside');
    
    if(chatViewLeft.classList.contains('four')){

        // remove aside
        chatViewLeftAside.innerHTML = ""
        // remove style that display's it
        chatViewLeft.classList.remove('four');

    }

}