



<div 
    class="globalIconBtn <?= isset($class)? esc($class): ''?>" 

    <? if( isset( $onclick ) ):?>
        onclick="<?= esc(data: $onclick)?>"
    <?endif?>
    
    <?if(isset( $style)):?>
        style="<?=esc(data: $style)?>"
    <?endif?>

    <?if( isset( $redirect ) ):?>
        onclick="window.location = '<?= base_url( $redirect); ?>'"
    <?endif?>

    <?if( isset( $id ) ):?>
        id=" <?= esc($id); ?> "
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

    <?if(isset($text)):?>
        <?=esc(data: $text)?>
    <?endif?>

</div>

