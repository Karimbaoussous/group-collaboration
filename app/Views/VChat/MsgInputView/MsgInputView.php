
<style>

    .msgInputView {

        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1dvw;
        height: 100%;
        background-color: var(--black-30);

    }


    .msgInputView .msg{

        width: 80%;

        padding: var(--padding-h);
        border-radius: var(--padding-h);

    }


    .msgInputView .btns{

        display: flex;
        gap: var(--gap-w);

    }
    

</style>


<footer class="msgInputView">

    <input  type="text" class="msg" id="msgInputViewMsg" placeholder="Hi!" >
    
    <div class="btns" id="msgInputViewBtns">

        <?= 
            view("Global/iconBtn", array(
                "src"       => base_url(relativePath: "icons/send.png"),
                "onclick"   => "handleSendMsgBtnClick()",
                "style"     =>  "background: var(--white); border-radius: 25%; padding: var(--padding-h);",
                "size"      => "4dvh", 
            ))
        ?>

    </div>


</footer>


