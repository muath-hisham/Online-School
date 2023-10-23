const exit = document.querySelector("#exit");
const edit = document.querySelector("#edit");
const backEdit = document.querySelector(".back-edit");

$(backEdit).hide();

edit.addEventListener('click',function(){
    $(backEdit).fadeIn("slow");
});

exit.addEventListener('click',function(){
    $(backEdit).fadeOut("slow");
});

// change image
let image = document.querySelector(".image");
let input = document.querySelector("#input");
let profile = document.querySelector(".profile-img");
let file;

image.onclick = () => {
    input.click();
};

input.addEventListener('change', () => {
    file = this.input;

    if (!fileValidation()) {
        alert('This extension is not valid');
        file.value = "";
    }
    else{
        let fileReader = new FileReader();
        console.log('fileURL');
        fileReader.onload = () => {
            let fileURL = fileReader.result;
            console.log('fileURL2');
            let imgTag = '<img src="${fileURL}" class="image">';
            profile.innerHTML = imgTag;
        };
        fileReader.readAsDataURL(file);
    }
});

function fileValidation() {
    fileInput = file;
    filePath = fileInput.value;
    if (filePath.includes(".jpeg" | ".jpg" | ".png")) {
        return false
    } else {
        return true
    }
}