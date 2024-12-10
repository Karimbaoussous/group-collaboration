

let removeAdminBTN = null;

function handleAdminMousedown(div){

    // console.log(div)

    const tag = div.lastElementChild;

    if(tag.classList.contains("admin")){
        // console.log("admin");
        return
    }

    removeAdminBTN = document.createElement("div");
    removeAdminBTN.classList.add("remove")
    removeAdminBTN.onclick = handleRemoveMemberClick;
    removeAdminBTN.textContent = "remove";

    div.appendChild(removeAdminBTN)

}


function handleAdminMouseleave(div){

    if(removeAdminBTN){
        removeAdminBTN.remove()
    }

}


async function handleRemoveMemberClick(e){

    const btn = e.target
    // console.log(btn)
    const container = btn.parentElement
    // console.log(container)
    const hiddenInput = container.children[1];

    // console.log(hiddenInput.value)

    const formData = new FormData();

    formData.append('id', hiddenInput.value);


    try {

        const response = await fetch("/member/remove", {
            method: 'post',
            body: formData,
            credentials: 'include', // Enables session
        })

        if(!response.ok){
            console.log("not ok response");
        }

        const data = await response.json();

        if("alert" in data){
            alert(data['alert'])
            return false;
        }else if ("msg" in data){
            console.log(data['msg'])
            return false;
        }else if ("error" in data){
            console.error(data['error'])
            return false;
        }else if("status" in data){

            if(data['status'] != "ok"){
                console.error("status not ok")
            }
            container.remove();
            return true;
        }
        
    } catch (error) {

        console.error(error);
        
    }



}


let removeMemberBTN = null;

function handleMemberMousedown(div){

    // console.log(div)

    const tag = div.lastElementChild;

    if(tag.classList.contains("admin")){
        // console.log("admin");
        return
    }

    removeMemberBTN = document.createElement("div");
    removeMemberBTN.classList.add("remove")
    removeMemberBTN.onclick = async(e)=>{

        if(!confirm("Are you sure you wanna quit the group?")){
            return ;
        }

        const removed = await handleRemoveMemberClick(e); // remove self from groups 
        if(!removed) return;
        const reloaded = await handleSearchGroupsViewClick(""); // reload groups list
        if(!reloaded) return;

        // reset the page
        const chatViewLeft = document.getElementById('chatViewLeft');
        const chatViewLeftMain = document.getElementById('chatViewLeftMain');
        const chatViewLeftAside = document.getElementById('chatViewLeftAside');

        chatViewLeftMain.innerHTML =  `
            <div class="greeting">
                what's up ${globalUsername} , let's chat
            </div>
        `
            
        if(chatViewLeft.classList.contains('four')){
            // remove aside
            chatViewLeftAside.innerHTML = ""
            // remove style that display's it
            chatViewLeft.classList.remove('four');

        }

        if(chatViewLeft.classList.contains('forMembers')){
            chatViewLeft.classList.remove('forMembers'); 
        }

        if(chatViewLeft.classList.contains('forGroup')){
            chatViewLeft.classList.remove('forGroup'); 
        }

    };

    removeMemberBTN.textContent = "Quit";

    div.appendChild(removeMemberBTN)

}


function handleMemberMouseleave(div){

    if(removeMemberBTN){
        removeMemberBTN.remove()
    }

}