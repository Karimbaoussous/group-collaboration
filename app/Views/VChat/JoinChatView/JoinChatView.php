

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

  
    <div class="JoinChatViewBtn" onclick="handleJoinChatBtnClick('<?=$group['id']?>')">join</div>
 

</div>


