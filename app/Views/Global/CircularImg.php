

<style>

    .CircularImgImg{

        border-radius: 50%;
        object-fit: cover;
        user-select: none;
        
    }

</style>

<img class="CircularImgImg"
    src="<?= esc($src)?>" 
    alt="<?= esc($alt)? esc($alt): "img" ?>"
    style="
        width:  <?= esc($size)? esc($size): '5dvh' ?>;
        height: <?= esc($size)? esc($size): '5dvh' ?>;
    "
>