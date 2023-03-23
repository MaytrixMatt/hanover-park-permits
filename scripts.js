//This function works on displaying the fields based on whichever facility was selected
// This should modify html code ***
function displayFields() {
    // 1.) check the option that was chosen
    var facilityID = "#facility";
    var facility = $(facilityID).val();

    var fieldElem = $("#field_requested");
    // 2.) check the facility and decide what fields to display
    if (facility == "f1") {
        fieldElem.append(
            $('<option></option>').val('1f1').html('T-Ball')
            $('<option></option>').val('2f1').html('Other')
        );
    } else if (facility == "f2") {
        fieldElem.append(
            $('<option></option>').val('1f2').html('T-Ball')
            $('<option></option>').val('2f1').html('Other')
        );
    } else if (facility == "f3") {
        fieldElem.append(

        );
    } else if (facility == "f4") {
        fieldElem.append(

        );
    } else if (facility == "f5") {
        fieldElem.append(

        );
    } else if (facility == "f6") {
        fieldElem.append(

        );
    }

    var mySelect = $('#mySelect');

    mySelect.append(
        $('<option></option>').val(val).html(text)
    );




}

var fieldNameGrid = $()