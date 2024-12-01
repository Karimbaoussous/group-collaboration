

<style>



    .leftMsgContainer{
        display: flex;
        gap: var(--gap-h)

    }


    .leftMsgSubContainer{
        display: flex;
    }


    .leftMsg{

        display: flex;
        flex-direction: column;

        --border-radius: 1dvw;
        border-radius: 0 var(--border-radius) var(--border-radius) var(--border-radius);
        
        background-color: var(--black-30);
        padding: var(--padding-h);
        gap: var(--gap-h);
        
        max-width: var(--max-msg-width);

    }

    .leftMsgContainer img{

        --size: 5dvh;
        width: var(--size);
        height: var(--size);
        border-radius: 50%;

    
    }

    .leftMsg .content{

        color: var(--white);
        word-break: break-word;


    }
    
    .leftMsg .title{

        color: skyblue;
        word-break: break-word;

    }


    .leftMsgContainer .moreBtn{

        display: flex;
  
        cursor: pointer;
        border-radius: var(--padding-h);
        padding: var(--padding-h);
        background-color: var(--black-150);

    }

    .leftMsgContainer .optionsBtn{
        display: flex;
  
        cursor: pointer;
        border-radius: var(--padding-h);
        padding: var(--padding-h);
        background-color: var(--black-150);
    }


</style>


<div class="leftMsgContainer" id="leftMsgContainer<?= esc($index) ?>" >


    <img src="<?= isset($src)? esc(data: $src): null ?>" alt="profile image">

    <div  class="leftMsgSubContainer" 
        <? if(esc($isAdmin)):?>
            onmouseenter="handleLeftMsgContainerMouseEnter(this)"
            onmouseleave="handleLeftMsgContainerMouseLeave(this)"
        <? endif; ?>  
    >

        <div class="leftMsg">

            <bdi class="title">
                <?=esc(data: $sender)?>
            </bdi> 

            <bdi class="content">
                <?=esc(data: $body)?>
            </bdi>

        </div>

    </div>
   

</div> 



