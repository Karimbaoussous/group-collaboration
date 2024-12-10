<style>

    :root{
        --upload-image-size: 20dvh;
    }


    .uploadImageContainer {

       
        position: relative;

        display: flex;
        justify-content: center;
        align-items: center;

        width: var(--upload-image-size);
        height: var(--upload-image-size);

        border-radius: 50%;
        overflow: hidden;

        border: 3px solid #4caf50;

        cursor: pointer;

    }


    .uploadImageContainer img {

        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;

    }


    .uploadImageContainer .btn {

        --size: calc(var(--upload-image-size) * 0.1);

        position: absolute;

        display: none;

        background-color: black;

        opacity: 0.8;
     
        border-radius: 50%;
      
        width: var(--size);
        height: var(--size);
        padding: var(--size);

        user-select: none;

    }

    .uploadImageContainer:hover .btn {

        display: flex;
        align-items: center;
        justify-content: center;
        border: calc(var(--gap-h) * 0.5) solid var(--white);


    }

    .uploadImageContainer:hover .btn .img{

        --size: calc(var(--upload-image-size) * 0.2);
        width: var(--size);
        height: var(--size);
        object-fit: cover;
        border-radius: 50%;  

    }

    


</style>



<div class="uploadImageContainer" 
    onclick="handleUploadImageContainer(this)"
>

    <img
        <?if(!isset($useBaseURL)):?>
            src="<?= isset($src)?  base_url($src): base_url(relativePath: '/imgs/img.png')?>" 
        <?else:?>
            src="<?= $src?>"
        <?endif?>
        alt="Profile Image"
    >

    <input type="file"  name="<?= isset($name) ? $name : 'image' ?>" accept="image/*" 
        onchange="(()=>{
            uploadImagePreview(this);
            <?= isset($onchange) ? $onchange : '' ?>
        })()"
        hidden
    >

    <div class="btn">
       <img class="img" src="<?=base_url('icons/plusWhite.png')?>">
    </div>
    
</div>

