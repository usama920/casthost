function Upload(reference, input, size, error, minHeight, minWidth) {
    // if(input == 'shop_logo') {
    //Get reference of FileUpload.
    var fileUpload = document.getElementById(input);
    // var errorblock = document.getElementById(error);
    //Check whether the file is valid Image.
    var regex = new RegExp("([a-zA-Z0-9s_\\.-:])+(.jpg|.png|.jpeg)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
        //Check whether HTML5 is supported.
        if (typeof fileUpload.files != "undefined") {
            const target = reference;
            if (target.files && target.files[0]) {
                const maxAllowedSize = size * 1024 * 1024;
                if (target.files[0].size > maxAllowedSize) {
                    jQuery(error).html("File size should be less than 1mb");
                    target.value = "";
                    return false;
                } else if (target.files[0].size < maxAllowedSize) {
                    jQuery(error).html("");
                    //Initiate the FileReader object.
                    var reader = new FileReader();
                    //Read the contents of Image File.
                    reader.readAsDataURL(fileUpload.files[0]);
                    reader.onload = function (e) {
                        //Initiate the JavaScript Image object.
                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        //Validate the File Height and Width.
                        image.onload = function () {
                            var height = this.height;
                            var width = this.width;
                            if (height > minHeight && width > minWidth) {
                                jQuery(error).html("");
                                return;
                            } else if (height < minHeight || width < minWidth) {
                                jQuery(error).html(
                                    "Uploaded image has invalid Height and Width."
                                );
                                fileUpload.value = "";
                                return;
                            }
                        };
                    };
                }
            }
        } else if (typeof fileUpload.files == "undefined") {
            jQuery(error).html("This browser does not support HTML5.");
            fileUpload.value = "";
            return;
        }
    } else if (!regex.test(fileUpload.value.toLowerCase())) {
        jQuery(error).html("Please select a valid file.");
        fileUpload.value = "";
        return;
    }
    // }
}

