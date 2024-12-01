


<style>


    .globalIconBtn{

        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        user-select: none;

    }



</style>


<div 
    class="globalIconBtn" 

    <? if( esc( $onclick ) ):?>

        onclick="<?= esc(data: $onclick)?>"

    <?endif?>
    
    <?if(esc($style)):?>

        style="<?=esc(data: $style)?>"

    <?endif?>
>

    <img  

        style=" 
            width: <?= isset($size)? esc($size): "5dvh"?>; 
            height: <?= isset($size)? esc($size): "5dvh"?>; 
        "
        src="<?=esc(data: $src)?>" 
        alt="icon"
    >

</div>

