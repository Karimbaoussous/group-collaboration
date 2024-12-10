
<style>

    .progressBar{

        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);

        display: flex;
        gap: var(--gap-w);
        padding: var(--padding-w);
        user-select: none;

    }


    .progressBar .bar{

        height: 1dvh;
        width: 4dvw;

    }

</style>



<footer class="progressBar">
    <?for($i = 0; $i < $max; $i++):?>

        <?  
            $color = "";
            if($i< $currently){ // active bar case
                $color = isset($color1)? esc($color1): "var(--blue)";
            }else{
                $color = isset($color0)? esc($color0): "var(--gray)";
            }
        ?>
        <div 
            class="bar" 
            style="background-color: <?=$color?>" 
        ></div>   
    <?endfor?>
</footer>