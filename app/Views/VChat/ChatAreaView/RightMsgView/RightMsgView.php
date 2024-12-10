


<style>


    .rightMsgContainer{

        display: flex;
        justify-content: flex-end;
        gap: var(--gap-h)

    }


    .rightMsgSubContainer{
        display: flex;
        justify-content: flex-end;
    }


    .rightMsg{
     
        display: flex;
        flex-direction: column;
        order: 1;
       
        --border-radius: 1dvw;
        border-radius: var(--border-radius) 0  var(--border-radius) var(--border-radius);
        
        background-color: var(--black-25);
        padding: var(--padding-h);
        gap: var(--gap-h);

        max-width: var(--max-msg-width);
        min-width: var(--min-msg-width);
        
    }


    .rightMsg .content{
       
        color: var(--white);
        word-break: break-word;
    }

    .rightMsgContainer .moreBtn{

        display: flex;

        cursor: pointer;
        border-radius: var(--padding-h);
        padding: var(--padding-h);
        background-color: var(--black-150);

    }

    .rightMsgContainer .optionsBtn{
        display: flex;

        cursor: pointer;
        border-radius: var(--padding-h);
        padding: var(--padding-h);
        background-color: var(--black-150);
    }

    .rightMsgSubContainer .btnsContainer{

        display: flex;
        gap: var(--gap-h);
        text-transform: capitalize;

    }

    .rightMsgSubContainer .time{

        display: flex;
        align-items: center;
        justify-content: flex-end;
        color: var(--white);
        font-size: small;

    }


</style>


<div class="rightMsgContainer"  id="rightMsgContainer<?= esc($index) ?>">

    <div  class="rightMsgSubContainer" 
    
        onmouseenter="handleRightMsgContainerMouseEnter(this)"
        onmouseleave="handleRightMsgContainerMouseLeave(this)"

    >
        
        <div class="rightMsg"> 
        
            <bdi class="content">
                <?=esc(data: $body)?>
            </bdi>

            <div class="time">
                <?= esc($time)?>
            </div>
        
        </div>

    </div>

</div> 


<script>


    function scrollToLastMsg() {

        const container = document.getElementById("chatAreaView");
      
        let lastMessage = container.children[container.children.length - 2];

        if(!lastMessage) return

        lastMessage.scrollIntoView({ 
            behavior: "smooth", 
            block: "end"
        });

        // console.log(lastMessage);

    }

    scrollToLastMsg()



</script>

