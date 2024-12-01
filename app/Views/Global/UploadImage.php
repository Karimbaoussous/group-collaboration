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


    .uploadImageContainer .text {

        --size: calc(var(--upload-image-size) * 0.1);

        position: absolute;

        display: none;

        font-size: calc(var(--size) * 3);

        color: white;
        background-color: black;

        text-align: center;

        opacity: 0.8;
     
        border-radius: 50%;

      
        width: var(--size);
        height: var(--size);;
        padding: var(--size);

    }


    .uploadImageContainer:hover .text {

        display: flex;
        align-items: center;
        justify-content: center;
        border: calc(var(--gap-h) * 0.5) solid var(--white);


    }


</style>



<div class="uploadImageContainer" 
    onclick="document.getElementById('UploadImageFile').click()"
>

    <img id="preview" 
        src="<?= base_url(relativePath: '/imgs/img.png')?>" 
        alt="Profile Image"
    >

    <input type="file" 
        id="UploadImageFile" name="image" accept="image/*" onchange="uploadImagePreview(event)"
        hidden
    >

    <div class="text">+</div>
    
</div>


<script>

    function uploadImagePreview(event) {

        const preview = document.getElementById('preview');
        const file = event.target.files[0];

        if (file) {

            preview.src = URL.createObjectURL(file);
            
        }

    }


</script>
