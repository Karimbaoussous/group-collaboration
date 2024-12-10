

function handleUploadImageContainer(container){

    // press the input
    container.children[1].click();

}


function uploadImagePreview(input) {

    const preview = input.parentElement.children[0];
    const file = input.files[0];

    if (file) {

        preview.src = URL.createObjectURL(file);
        
    }

}