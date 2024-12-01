

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
    removeMemberBTN.onclick = handleRemoveMemberClick;
    removeMemberBTN.textContent = "remove";

    div.appendChild(removeMemberBTN)

}


function handleMemberMouseleave(div){

    if(removeMemberBTN){
        removeMemberBTN.remove()
    }

}


async function handleRemoveMemberClick(e){

    const btn = e.target

    const container = btn.parentElement

    const hiddenInput = container.children[1];

    // console.log(hiddenInput.value)

    const formData = new FormData();

    formData.append('id', hiddenInput.value);

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
        return;
    }else if ("msg" in data){
        console.log(data['msg'])
        return;
    }else if ("error" in data){
        console.error(data['error'])
        return;
    }else if("status" in data){

        if(data['status'] != "ok"){
            console.error("status not ok")
        }
        container.remove();
    }


}