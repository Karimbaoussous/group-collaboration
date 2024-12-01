

<style>

    .MsgDateView{

        display: flex;
        justify-content: center;
        user-select: none;
    
    }


    .MsgDateView .date{

        background-color: var(--black-30);
        color: var(--white);

        font-size: small;

        padding: var(--padding-h);
        border-radius: var(--padding-h);

    }

</style>


<section class="MsgDateView" id="MDV<?= esc($date) ?>">

    <div class="date">
        <?= esc($date) ?>
    </div>

</section>