


async function handleCreateGroupBtnClick(){


    console.log("handleCreateGroupBtnClick")

    const response = await fetch("/group/create", {
        method: 'GET',
        credentials: 'include', // Enables session
    })

    // if (!response.ok) {
    //     throw new Error(`HTTP error! status: ${response.status}`);
    // }
    // if (response.headers.get('content-length') === '0') {
    //     throw new Error('Empty response body');
    // }

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
    }else if("html" in data){

        const groupsAside =document.getElementById("groupsAside");
        // console.log(data['html']);
        groupsAside.innerHTML = data['html']

        return;
    }

    return false

}