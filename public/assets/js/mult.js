import Dropzone from "dropzone";

// Отключает автоматическое обнаружение всех форм Dropzone на странице
Dropzone.autoDiscover = false;

const dropzoneElement = document.getElementById('my-dropzone');
const formElement = document.getElementById('product-form');

if (dropzoneElement) {
    const myDropzone = new Dropzone(dropzoneElement, {
        url: formElement.action,

        // Отключает автоматическую обработку очереди загрузки файлов
        autoProcessQueue: false,

        uploadMultiple: true,
        paramName: "image_list",
        dictDefaultMessage: "Загрузите сюда свои файлы",
        clickable: true,
        parallelUploads: 4, // количество загружаемых файлов
        //previewTemplate:

        init: function () {
            let myDropzoneInstance = this;

            //formElement.querySelector("button[type=submit]").addEventListener("click", function (e) {
            formElement.addEventListener("submit", function (e) {
                e.preventDefault();
                // Останавливает дальнейшую передачу текущего события в фазе всплытия или погружения
                e.stopPropagation();

                // Проверить, есть ли файлы для загрузки
                if (myDropzoneInstance.getQueuedFiles().length > 0) {
                    // Отправить файлы через Dropzone
                    myDropzoneInstance.processQueue();
                } else {
                    // Если файлов нет, отправить форму стандартным способом
                    formElement.submit();
                }
            });


            //myDropzoneInstance.on("addedfile", file => {
            //    console.log("A file has been added", file);
            //});

           myDropzoneInstance.on("sendingmultiple", function (data, xhr, formData) {
             let tempFormData = new FormData(formElement);

             // Append each entry from the temporary form data to the original formData
             tempFormData.forEach((value, key) => {
                 console.log(key, value)
                 formData.append(key, value);
             });

           });


            myDropzoneInstance.on("successmultiple", function (files, response) {
                // Redirect or show a message
                console.log("Successfully uploaded!");
                // Optionally redirect to another page
                //window.location.href = "/success";
            });

             myDropzoneInstance.on("errormultiple", function (files, response) {
                 // Handle error
                 console.error("Error uploading files");
             });
        }
    });
}