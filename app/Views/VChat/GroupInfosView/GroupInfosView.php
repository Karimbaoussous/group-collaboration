
<style>


    .groupInfosView{

        display: flex;
        align-items: center;
        gap: var(--gap-h);
        background-color: var(--black-30);
        /* padding: 0 var(--padding-h); */
        cursor: pointer;

    }


    .groupInfosView img{

        --size: 5dvh;
        width: var(--size);
        height: var(--size);
        border-radius: 50%;

    }


    .groupInfosView .content {
        color: var(--white);

    }


    /* .groupInfosView .content .name{

    } */

    .groupInfosView .content .description{

        color: var(--black-100);
    }



</style>

<style>

    
    .GroupMembersView{

        display: flex;
        flex-direction: column;
        gap: 1dvh;

        background-color: var(--black-10); 

    }


    .GroupMembersView .members{

        display: flex;
        flex-direction: column;
        gap: var(--gap-h);

        height: 90dvh;
        overflow-y: auto;


    }

    .GroupMembersView .members .membersContainer{

        display: flex;
        align-items: center;
        background-color: var(--black-30);
        gap:  var(--gap-h);
        padding: var(--gap-h);
        cursor: pointer;

    }

    .GroupMembersView .members .membersContainer .content{

        display: flex;
        flex-direction: column;

    }

    .GroupMembersView .members .membersContainer img{

        --size: 5dvh;
        width: var(--size);
        height: var(--size);
        border-radius: 50%;

    }

    .GroupMembersView .members .membersContainer .content .username{

        text-overflow: ellipsis; /* Adds ellipsis (...) at the end */
        color: var(--black-200);

    } 

    .GroupMembersView .members .membersContainer .content .about{

        color: var(--black-100);

    }

</style>


<? 

    if(isset($test)){

        $group = array(
            "id" => "1",
            "image" => base_url('imgs/img.png'),
            "title" => "name of group",
            "description" => "description of group",
        );

    }


?>


<header class="groupInfosView" onclick="handleGroupInfosClick('<?=$group['id']?>')">

    <img src="<?=$group['image']?>" alt="group img">

    <div class="content">
        <div class="name">
            <?=$group['title']?>
        </div>
        <div class="description">
            <?=$group['description']?>
        </div>
    </div>

</header>


