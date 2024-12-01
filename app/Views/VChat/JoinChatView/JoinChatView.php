

<style>


    .JoinChatView{

        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);

        border-radius: var(--padding-w);
        padding: var(--padding-w);

        display: grid;
        gap: var(--gap-w);

        background-color: var(--black-30);
        color: var(--white);

        z-index: 1000;

        width: 50%;
        
    }


    .JoinChatView .group{
        
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: var(--gap-w);

    }


    .JoinChatView .group .title{

        font-size: large;
        font-weight: bold;

    }


    .JoinChatView .group .username strong{

        font-size: large;
        font-weight: bold;

    }


    .JoinChatView header{

        display: flex;

    }


    .JoinChatView .btn{

        padding: var(--padding-w);
        border-radius:  var(--padding-w);
        background-color: var(--green);

        cursor: pointer;
        user-select: none;


        text-transform: capitalize;

        text-align: center;


    }




</style>



<div class="JoinChatView"  id="JoinChatView">

    <header>
        <?= view(
            "Global/IconBtn", 
                array(
                    "size"  => "var(--padding-w)",
                    "src"   => base_url("icons/cancel_white.png"),
                    "alt"   => "cancel icon",
                    "style" => "",
                    "onclick" => "handleJoinChatRemoveBtnClick()"
                )
            )
        ?>
    </header>


    <div class="group">
        <?= view(
            "Global/CircularImg", 
                array(
                    "size"  => "10dvw",
                    "src"   =>  esc($group["image"]),
                    "alt"   => "group image"
                )
            )
        ?>
        <div class="title"><?= esc($group["title"])?></div>
    </div>

    <div class="group">
        <div class="username">
            created by <strong><?= esc($user["username"])?></strong>
        </div>
        <?= view(
             "Global/CircularImg", 
                array(
                    "size"  => "5dvw",
                    "src"   =>  esc($user["image"]),
                    "alt"   => "admin image"
                )
            )
        ?>
       
    </div>

  
    <div class="btn" onclick="handleJoinChatBtnClick('<?=$group['id']?>')">join</div>
 

</div>


