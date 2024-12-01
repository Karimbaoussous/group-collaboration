
<link rel="stylesheet" href="<?= base_url(relativePath: 'css/groupView.css')?>">

<?php 
    // create elements to test
    $grps = [];


    function testGroups(){

        $groupLocal = [];
        
        for($i=0; $i< 10;$i++){
            $groupLocal[$i] = array(
                "id" => $i,
                "image" => base_url("imgs/img.png"),
                "title" => "group $i",
                "description" => " description $i"
            );
        }

        return $groupLocal;
    }

    // $grps = testGroups();


    if(isset($groups)){
        $grps = array_merge($grps, $groups);
    }



?>


<aside class="groupsView">


    <?= view("Global/SearchInput", 
        array(
            "onclickSearchInput" => "handleSearchGroupsViewClick"
        )
    )?>

    <div class="title" id="groupsNumber">
        <?= sizeof( value: $grps). " groups"?>
    </div>


    <section class="groups" id="groupsView">

        <? 
            foreach($grps as $group){

                echo view(
                    "VChat/GroupView/GroupCardView", 
                    array(
                        "group" => $group
                    )
                );
                
            }

        ?>

    </section>
  

</aside>


<script>


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

        const formData = new FormData();

        formData.append('id', groupID);

        const response = await fetch("/group/load", {
            method: 'post',
            body: formData,
            credentials: 'include', // Enables session
        })

        if(!response.ok){
            console.log("not ok response");
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

            return;

        }else if("error" in data){
            console.error(data['error'])
            return;
        }else  if("alert" in data){
            alert(data['alert'])
            return;
        }else if ("msg" in data){
            console.log(data['msg'])
            return;
        }else if("html" in data){

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

    
    const groupsView = document.getElementById('groupsView');

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

            groupsView.innerHTML = data['html']
            const groupsNumber = document.getElementById('groupsNumber');
            groupsNumber.innerHTML = data['groupsNumber'] + " Groups";
            
        }

        
    }

</script>