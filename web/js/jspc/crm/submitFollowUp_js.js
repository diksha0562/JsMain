$(document).ready(function() {
    showDateSelectionField("date1","2017","2018");

    $("#followupStatus").change(function(){
        var selectedVal = $(this).find(':selected').val();
        if(selectedVal=="F"){
            $("#reason").removeAttr("disabled");
            $("#reason").removeClass("crm-disabled");
            $("#reasonText").removeAttr("disabled");
            $("#reasonText").removeClass("crm-disabled");
        }
        else{
            $("#reason").attr("disabled","disabled");
            $("#reason").addClass("crm-disabled");
            $("#reasonText").attr("disabled","disabled");
            $("#reasonText").addClass("crm-disabled");
        }
    });
});