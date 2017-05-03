var requiredFields = ["#name", "#age", "#sathiName", "#phone", "#email", "#hashtag"];
var errorTitle = ["name", "age", "sathi's name", "phone number", "E-mail Id", "hashtag"];
var email_regex = /^([A-Za-z0-9._%+-]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i;
var validForm, formData = [];
var photoUploaded;
$(document).ready(function(e) {
    photoUploaded = false;
    $("#upBtn").on("click", function() {
        $("#fileToUpload").click();
    });
	$("#submitform").submit(function(event){
		validForm = true;
        $.each(requiredFields, function(index, elem) {
            if ($(elem + "Field").val().length == 0) {
                $(elem + "Error").html("Please enter " + errorTitle[index]).removeClass("dn");
                $(elem + "Field").addClass("brdr1");
                validForm = false;
            }
        })
        if ($("#emailField").val().length != 0 && email_regex.test($("#emailField").val()) == false) {
            $("#emailError").html("Please enter a valid E-mail Id");
            validForm = false
        }
        if(photoUploaded == false) {
            validForm = false;
            $("#photoError").removeClass("vishid");
        }
		if(validForm == false) {
		  event.preventDefault();
		}
	});
	$("#submitform input").focus(function() {
            $(this).removeClass("brdr1");
            if($(this).prev().attr("id")) {
                if($(this).prev().attr("id").indexOf("Error")!= -1) {
                    $(this).prev().html("");
                }    
            } 
        });
});

function readURL(input) {
    $("#photoError").addClass("vishid");
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            photoUploaded = true;
        };
        reader.readAsDataURL(input.files[0]);
    }
}