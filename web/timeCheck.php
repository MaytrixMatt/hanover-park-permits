<html lang="en">
<head>
    <?php
        include('library.php');
        if(!isset($id)){
            $id = 1;
        }
        if(!isset($reqDate)) {
            $reqDate = "2023-01-01"; 
        }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Time Checker</title>
</head>
<body onload="loadFacilities()">
    <table class="table">
    <thead>
        <tr>
            <th>Field Name</th>
            <th>Field Reservation Status</th>
        </tr>
    </thead>
    <tbody>
        <?php

            // problem: drop down boxes are hard coded atm
            // solution: use javascript to store the results; use jquery to modify the drop downs
            
            $conn = get_database_connection();

             // Build the SELECT statement
             $sql = "SELECT * FROM fields WHERE fld_loc_id=".$id;
     
             // Execute the query and save the results
             $result = $conn->query($sql);
            
            $sqlFacilitiesAndFields = <<<SQL
                    SELECT fld_id, fld_loc_id, fld_name, loc_name, loc_id
                    FROM fields
                    JOIN location ON loc_id = fld_loc_id
            SQL;
            $resultFacilitiesAndFields = $conn->query($sqlFacilitiesAndFields);
            
            
            
            $allFacsFields = array();
            $onlyFacs = array();
            $onlyFacsID = array();
            $allFacsAndIDs = array();
             // Iterate over each row in the results
            $curFac = -1;
            $curFacFields = array();
            $allFldsAndIDs = array();
            
            while ($row = $resultFacilitiesAndFields->fetch_assoc())
            {
                if ($curFac != $row['loc_id'])
                {
                    if ($curFac != -1) 
                    {
                        $allFacsFields[$curFac] = $curFacFields;
                        $curFacFields = array_diff($curFacFields, $curFacFields);                      
                    }
                    
                    $curFac = $row['loc_id'];
                    array_push($onlyFacsID, $row['loc_id']);
                    array_push($onlyFacs, $row['loc_name']);
                    $allFacsAndIDs[$row['loc_id']] = $row['loc_name'];
                }
                array_push($curFacFields, $row['fld_id']);

                $allFldsAndIDs[$row['fld_id']] = $row['fld_name'];
                
            }
            $allFacsFields[$curFac] = $curFacFields; //fence post case for the last facility


            while ($row = $result->fetch_assoc())
            {
                echo "<tr>";
                echo "<td>" . $row['fld_name'] . "</td>";
                echo "<td>" . $row['fld_reserved'] . "</td>";
            }
            

            

            // How can Jacob use this code to check time:
            // The time information from the "applications" table can be accessed using php
            // 1.) an sql statement can be written to check if anyone requested that date
            // 2.) then the javascript will display the available days 
            // ***REMEMBER: AT THIS POINT IN TIME, WE ARE ONLY CHECKING WHO REQUESTED THE DATE (NO HOURLY LOGIC YET)
            

            // 1.) Person selects a field; page will reload
            // 2.) gives us chance to run another sql query
            // 2b.) get the field chosen; see the dates chosen for that field; display date chosen
            
            // need facility ids with each of the field ids



            // This SQL statement is necesary for finding the dates requested
            // SQL statement finds all field IDs and matches them with the dates
            // each field was requested.
            $sqlReqFldsAndDates = <<<SQL
                SELECT app_date_req, app_afl_id
                FROM applications
                ORDER BY app_afl_id DESC, app_date_req DESC 
            SQL;

            $sqlReqFldsAndDates = $conn->query($sqlReqFldsAndDates);
            $allFieldsDates = array();

            $reqFieldsID = array();

            $curField = '';
            $curFieldsDates = array();


            while ($row = $sqlReqFldsAndDates->fetch_assoc())
            {
                if ($curField != $row['app_afl_id'])
                {
                    if ($curField != '') 
                    {
                        $allFieldsDates[$curField] = $curFieldsDates;
                        $curFieldsDates = array_diff($curFieldsDates, $curFieldsDates);                      
                    }
                    
                    $curField = $row['app_afl_id'];
                    array_push($reqFieldsID, $row['app_afl_id']);
                }
                array_push($curFieldsDates, $row['app_afl_id']);
                
            }
            $allFieldsDates [$curField] = $curFieldsDates; 
            
            // check if the dates for the selected field
            


            // How can someone in the future use this code to implement the hour-logic:
            // 1.) While accessing the fields and facilities, the times that each facility is accessed may also be requested
            // 2.) With the times requested in an array, javascript can perform the logic needed to display the available
            //      times that the user is allowed to request



            // $sqlAvailableDates = <

            // idea for checking all applications where the requested date is NOT
            // 1.) Use a for loop
            // 2.) Use reqFieldsID[i] to access the requested dates for that field 
            //      through allFieldsDates[reqFieldsID[i]]
            //      ----This returns a list of requested dates for that field
            // 3.) Generate a string: iterate throug the list to generate a string 
            //      for the boolean condition of the future sql statement


            // what fields are available for a given date
        ?>
        <script>
            
            var facilitiesAndFields = <?php echo json_encode($allFacsFields)?>; // key : value (map)
            var onlyFacs = <?php echo json_encode($onlyFacs)?>; //holds facility names
            var onlyFacsID = <?php echo json_encode($onlyFacsID)?>; //holds facility IDs
            var facsID_facsNames = <?php echo json_encode($allFacsAndIDs)?>;

            var fieldsAndDates = <?php echo json_encode($allFieldsDates)?>; // key (field_id) : value (array of dates)
            
            var fldID_fldNames = <?php echo json_encode($allFldsAndIDs)?>; // key (field_id) : value (field_name)
            // fieldsIDs don't start at 1 nor 0!!!!
            // console.log(onlyFieldsID);

            

            function loadFacilities() {
                
                // console.log(onlyFacs);
                var facCheckBoxes = $('#facility');
                for (var i = 0; i < onlyFacs.length; i++) {
                    var onclickFunc = 'loadFields(\"' + onlyFacsID[i] + '\");';
                    var lbl = $('<label/>', {id: 'label_fac_' + onlyFacsID[i], text: onlyFacs[i]});
                    lbl.append(
                        $('<input/>', {type: 'checkbox', id: 'fac_' + onlyFacsID[i], value: onlyFacsID[i].toString(), onclick: onclickFunc})
                    );

                    lbl.appendTo(facCheckBoxes);
                    facCheckBoxes.append("<br>");
                    // loadFields(onlyFacs[i])
                    // $("#fac_" + i).click(loadFields(onlyFacs[i]));
                    // facDropDown.append(
                    //     $('<option></option>').val(i + 1).html(onlyFacs[i])
                    // );
                }
                
            }

           
            // This function loads fields as checkboxes
            // -Is run as an onclick function on each facility checkbox
            // 1.) check the value of the facility that ran this function
            // 2.) set the visibility to hidden 
            function loadFields(facID) {
                // console.log("This facility ID was loaded: " + facID);
                
                var fieldCheckBoxes = $('#fields');
                var correspFldIDs = facilitiesAndFields[facID];
                var fac = facsID_facsNames[facID];
                var facCheckboxStatus = $('#fac_' + facID).is(':checked'); //was the checkbox checked????
                
                for (var i = 0; i < correspFldIDs.length; i++) {
                    var curFieldID = correspFldIDs[i];
                    
                    // var onclickFunc = 
                    
                    if (facCheckboxStatus) {

                        // console.log(fldID_fldNames[curFieldID]);
                        var fldName = fldID_fldNames[curFieldID];

                        var onclickFunc = 'checkDateAvail(' + curFieldID + ')';
                        var lbl = $('<label/>', {for: 'fld_' + curFieldID, text: fac + ' @ ' + fldName, id: 'label_fld_' + curFieldID});
                        lbl.append(
                            $('<input/>', {type: 'checkbox', id: 'fld_' + curFieldID, value: fac + '_' + curFieldID})
                        );
                        lbl.appendTo(fieldCheckBoxes);
                    
                    } else if (!facCheckboxStatus) {

                        console.log("Deleting element: Field ID " + curFieldID );
                        $('#fld_' + curFieldID).remove();
                        $('#label_fld_'+ curFieldID).remove();

                    }
                    
                }
                
            }

            function checkDate(){
                var reqDate=$("#reqDate").val(); //takes the form of a string YYYY-MM-DD
                console.log(reqDate);
                
                // Check the fields available for this date
                // fieldsAndDates is a map with field id : dates requested

                // Jacob and Hayden working to display the fields available for a given date
                // --Possible by looking in the PHP map variable which holds each field that has requested dates
                // --Check whether any of those requested dates match the current requested date
                
                // 1.) find the fields requested
                var fieldsReq = [];
                console.log($('#fields').children());
                $('#fields').children().each(function () {
                    var curLabel = $(this);
                    var checkBox = curLabel.children();
                    
                    if (checkBox.is(':checked')) {
                        // fieldsReq.push(checkBox);
                        console.log(fieldsReq);
                        var curDate = new Date();
                        curDate.setDate(curDate.getDate() - 1);
                        var fldID = checkBox.attr('id');
                        fldID = fldID.substring(fldID.indexOf('_') + 1);
                        
                        var badDates = ["2023-04-05"]
                        for (var i = 0; i <= 10; i++) {
                            curDate.setDate(curDate.getDate() + 1);
                            var strDate = curDate.getUTCFullYear() + "-";
                            if (curDate.getUTCMonth() + 1 < 10) {
                                strDate = strDate + "0" + (curDate.getUTCMonth() + 1 ) + "-" ;
                            } else {
                                strDate = strDate + (curDate.getUTCMonth() + 1) + "-";
                            }

                            if (curDate.getUTCDate()< 10) {
                                strDate = strDate + "0" + curDate.getUTCDate();
                            } else {
                                strDate = strDate + curDate.getUTCDate();
                            }

                            if (badDates.indexOf(strDate) == -1) {
                                console.log(strDate);
                            } else {
                                console.log("Already scheduled: pick another date");
                            }
                        }
                    }

                    // make sure to throw eror when user requests bad date
                });
                
                
                // 2.) Display the next 30 days, exclude the ones that aren't available



            }
        </script>
        
        <!-- <div class="mb-3">
        <label for="Facility" class="form-label">Facility</label>
        <select class="form-select" id="facility" onchange="updateFields()" >
            
        </select>

        </div> -->
        <style>
            label {
                display: block;
            }
            input {
                display: inline-block;
            }
        </style>

        <div id="facility">
            
        </div>
        <br>

        <input type='date' id='reqDate'>
        <button id='date_button' onclick='checkDate()'>Check this date</button>
        <br>
        <br>
        Fields
        <div id="fields">

        </div>

        <br>
        <br>

    </tbody>
    </table>
</body>
</html>
