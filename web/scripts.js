//This function works on displaying the fields based on whichever facility was selected
// This should modify html code ***

function displayFields() {

    // Setup: run query to database to get all facilites with their fields
    // put these into arrays

    // Then define what the facilities chosen can be in the drop down
    // Then based on what facility was chosen, display the fields in a drop down
    

    // 1.) check the option that was chosen
    var mySelect = $('#mySelect');

    mySelect.append(
        $('<option></option>').val(val).html(text)
    );
}

// var fieldNameGrid = $();
