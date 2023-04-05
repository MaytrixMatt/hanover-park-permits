<html lang="en">
<head>
    <?php
        session_start();

        include('library.php');
        if(!isset($id)){
            $id = 1;
        }
        if(!isset($reqDate)) {
            $reqDate = "2023-01-01"; 
        }

        
        if (!isset($updatedFac)) {
            // Holds information about which facility checkbox was selected
            // Therefore, which fields should be displayed
            $updatedFac = -1; //Holds the id of the facility to be updated
            $updatedFacStatus = false;
        }

        if (!isset($updatedFld)) {
            // Holds information about which facility checkbox was selected
            // Therefore, which fields should be displayed
            $updatedFld = -1; //Holds the id of the facility to be updated
            $updatedFldStatus = false;
        }
        // echo isset($allFacsStatus);
        
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
            $facIDs_facNames = array();
             // Iterate over each row in the results
            $curFac = -1;
            $curFacFields = array();
            $fldIDs_fldNames = array();
            
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
                    $facIDs_facNames[$row['loc_id']] = $row['loc_name'];
                }
                array_push($curFacFields, $row['fld_id']);

                $fldIDs_fldNames[$row['fld_id']] = $row['fld_name'];
                
            }
            
            $allFacsFields[$curFac] = $curFacFields; //fence post case for the last facility
            
            if($_SESSION['allFacsStatus'] === null) {
                
                $allFacsStatus = array();
                foreach ($onlyFacsID as $facID) {
                    $allFacsStatus[$facID] = false;
                }
                $_SESSION['allFacsStatus'] = $allFacsStatus;
            } else {
                
                $allFacsStatus = $_SESSION['allFacsStatus'];
                if ($updatedFac != -1) {
                    $allFacsStatus[$updatedFac] = json_decode($updatedFacStatus);
                    echo "updating: " . $updatedFac . " to " . $updatedFacStatus;
                }
                $_SESSION['allFacsStatus'] = $allFacsStatus;
            }
            
            echo json_encode($_SESSION['allFacsStatus']);


            if($_SESSION['allFldsStatus'] === null) {

                $allFldsStatus = array();
                foreach($onlyFacsID as $facID) {
                    foreach(($allFacsFields[$facID]) as $fldID) {
                        $allFldsStatus[$fldID] = false;
                    }
                    $_SESSION['allFldsStatus'] = $allFldsStatus;
                }
            } else {
                $allFldsStatus = $_SESSION['allFldsStatus'];
                if ($updatedFld != -1) {
                    $allFldsStatus[$updatedFld] = json_decode($updatedFldStatus);
                }

                $_SESSION['allFldsStatus'] = $allFldsStatus;
            }
            // echo json_encode($allFacsStatus);

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
                array_push($curFieldsDates, $row['app_date_req']);
                
                
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
            // echo json_encode($allFieldsDates);
            // $date = new DateTime();
            // echo json_encode($date->format('Y-m-d'));
            // echo json_encode($allFieldsStatus);
        ?>
        <?php
            // $datecollecter="SELECT * FROM fields LEFT OUTER JOIN application_fields ON afl_fld_id=fld_id LEFT OUTER JOIN applications ON app_afl_id=afl_id AND app_date_req='$reqDate' WHERE app_date_req IS null"
            $datecollecter="SELECT * FROM fields LEFT OUTER JOIN application_fields ON afl_fld_id=fld_id LEFT OUTER JOIN applications ON app_afl_id=afl_id WHERE fld_id <> '$reqDate' AND app_date_req IS null;";
        ?>
        <script>
            
            var facilitiesAndFields = <?php echo json_encode($allFacsFields)?>; // key : value (map)
            var onlyFacs = <?php echo json_encode($onlyFacs)?>; //holds facility names
            var onlyFacsID = <?php echo json_encode($onlyFacsID)?>; //holds facility IDs
            var facsID_facsNames = <?php echo json_encode($facIDs_facNames)?>;

            var fieldsAndDates = <?php echo json_encode($allFieldsDates)?>; // key (field_id) : value (array of dates)
            
            var fldID_fldNames = <?php echo json_encode($fldIDs_fldNames)?>; // key (field_id) : value (field_name)
            // fieldsIDs don't start at 1 nor 0!!!!
            // console.log(onlyFieldsID);
            
            

            function loadFacilities() {
                
                // console.log(onlyFacs);
                // var facCheckBoxes = $('#facility');
                // for (var i = 0; i < onlyFacs.length; i++) {
                //     var onclickFunc = 'loadFields(\"' + onlyFacsID[i] + '\");';
                //     var lbl = $('<label/>', {id: 'label_fac_' + onlyFacsID[i], text: onlyFacs[i]});
                //     lbl.append(
                //         $('<input/>', {type: 'checkbox', id: 'fac_' + onlyFacsID[i], value: onlyFacsID[i].toString(), onclick: onclickFunc})
                //     );

                //     lbl.appendTo(facCheckBoxes);
                //     facCheckBoxes.append("<br>");
                //     // loadFields(onlyFacs[i])
                //     // $("#fac_" + i).click(loadFields(onlyFacs[i]));
                //     // facDropDown.append(
                //     //     $('<option></option>').val(i + 1).html(onlyFacs[i])
                //     // );
                // }
                console.log("NYI");
                
            }

           
            // This function loads fields as checkboxes
            // -Is run as an onclick function on each facility checkbox
            // 1.) check the value of the facility that ran this function
            // 2.) set the visibility to hidden 
            function updateSelectedFacility(facID) {
                // console.log("This facility ID was loaded: " + facID);
                
                // var fieldCheckBoxes = $('#fields');
                
                var allFacsStatus = <?php echo json_encode($allFacsStatus)?>; 
                console.log(allFacsStatus);
                console.log(facID);
                //PHP datatype holds the status of which facilities were selected
                // Should be a map from key (facID) : value (boolean representing selected or not)

                // var correspFldIDs = facilitiesAndFields[facID];
                // var fac = facsID_facsNames[facID];
                // var facCheckboxStatus = $('#fac_' + facID).is(':checked'); //was the checkbox checked????
                var facCheckboxStatus = allFacsStatus[facID];
                console.log(facCheckboxStatus);
                if (facCheckboxStatus == true) {
                    console.log("here");
                    facCheckboxStatus = false;
                } else if (facCheckboxStatus == false) {
                    console.log("now I'm here");
                    facCheckboxStatus = true;
                }
                console.log(facCheckboxStatus);
                window.location.replace("timeCheck.php?updatedFac=" + facID + "&" + "updatedFacStatus=" + facCheckboxStatus); //***must use json_decode(allFacsStatus) before use 


                // **** Needs to be done in php to be kept up to date ****
                // for (var i = 0; i < correspFldIDs.length; i++) {
                //     var curFieldID = correspFldIDs[i];
                    
                //     // var onclickFunc = 
                    
                //     if (facCheckboxStatus) {

                //         // console.log(fldID_fldNames[curFieldID]);
                //         var fldName = fldID_fldNames[curFieldID];

                //         var onclickFunc = 'checkDateAvail(' + curFieldID + ')';
                //         var lbl = $('<label/>', {for: 'fld_' + curFieldID, text: fac + ' @ ' + fldName, id: 'label_fld_' + curFieldID});
                //         lbl.append(
                //             $('<input/>', {type: 'checkbox', id: 'fld_' + curFieldID, value: fac + '_' + curFieldID})
                //         );
                //         lbl.appendTo(fieldCheckBoxes);
                    
                //     } else if (!facCheckboxStatus) {

                //         console.log("Deleting element: Field ID " + curFieldID );
                //         $('#fld_' + curFieldID).remove();
                //         $('#label_fld_'+ curFieldID).remove();

                //     }
                    
                // }
                
            }


            function updateSelectedField(fldID) {
                var allFldsStatus = <?php echo json_encode($allFldsStatus)?>; 
                console.log(allFldsStatus);
                console.log(fldID);
                //PHP datatype holds the status of which facilities were selected
                // Should be a map from key (facID) : value (boolean representing selected or not)

                // var correspFldIDs = facilitiesAndFields[facID];
                // var fac = facsID_facsNames[facID];
                // var facCheckboxStatus = $('#fac_' + facID).is(':checked'); //was the checkbox checked????
                var fldCheckboxStatus = allFldsStatus[fldID];
                console.log(fldCheckboxStatus);
                if (fldCheckboxStatus == true) {
                    console.log("here");
                    fldCheckboxStatus = false;
                } else if (fldCheckboxStatus == false) {
                    console.log("now I'm here");
                    fldCheckboxStatus = true;
                }
                console.log(fldCheckboxStatus);

                var reqDate=$("#reqDate").val(); //takes the form of a string YYYY-MM-DD
                console.log(reqDate);
                

                window.location.replace("timeCheck.php?updatedFld=" + fldID + "&" + "updatedFldStatus=" + fldCheckboxStatus + "&" + "reqDate=" + reqDate); //***must use json_decode(allFacsStatus) before use 
            }

            function checkDate(){
                var reqDate=$("#reqDate").val(); //takes the form of a string YYYY-MM-DD
                // console.log(reqDate);
                
                // // Check the fields available for this date
                // // fieldsAndDates is a map with field id : dates requested

                // // Jacob and Hayden working to display the fields available for a given date
                // // --Possible by looking in the PHP map variable which holds each field that has requested dates
                // // --Check whether any of those requested dates match the current requested date
                
                // // 1.) find the fields requested
                // var fieldsReq = [];
                // console.log($('#fields').children());
                // var allAvailableDates = [];

                // $('#fields').children().each(function () {
                //     var curLabel = $(this);
                //     var checkBox = curLabel.children();
                    
                //     if (checkBox.is(':checked')) {
                //         // fieldsReq.push(checkBox);
                //         console.log(fieldsReq + 'check');
                //         var curDate = new Date();
                //         curDate.setDate(curDate.getDate() - 1);
                //         var fldID = checkBox.attr('id');
                //         fldID = fldID.substring(fldID.indexOf('_') + 1);
                //         console.log(fieldsAndDates[fldID]);
                //         var badDates = fieldsAndDates[fldID];
                //         if (fieldsAndDates[fldID] != undefined){
                //             badDates = fieldsAndDates[fldID];
                //         }
                        
                //         for (var i = 0; i <= 30; i++) {
                //             curDate.setDate(curDate.getDate() + 1);
                //             var strDate = curDate.getUTCFullYear() + "-";
                //             if (curDate.getUTCMonth() + 1 < 10) {
                //                 strDate = strDate + "0" + (curDate.getUTCMonth() + 1 ) + "-" ;
                //             } else {
                //                 strDate = strDate + (curDate.getUTCMonth() + 1) + "-";
                //             }

                //             if (curDate.getUTCDate()< 10) {
                //                 strDate = strDate + "0" + curDate.getUTCDate();
                //             } else {
                //                 strDate = strDate + curDate.getUTCDate();
                //             }

                //             if (badDates.indexOf(strDate) == -1) {
                //                 allAvailableDates.push(strDate);
                //                 // $("#availability").append($('<p>', {id: 'fld_' + fldID, text: (strDate)}));
                //                 // console.log("trying smth" + fldID + " " + strDate);
                                
                //             } else {
                //                 allaAvailableDates.push("This date is not available: " + strDate);
                //             }
                //             // else {
                //             //     $("#availability").append($('<p>', {id: 'fld_' + fldID, text: (strDate + " Already scheduled: pick another date:")}));
                                
                //             // }
                //         }
                //     }
                    window.location.replace('timeCheck.php?reqDate=' + reqDate);
                    // make sure to throw eror when user requests bad date
                
                
                
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
            
            <?php
                
                foreach ($onlyFacsID as $facID) {
                    $curElem = "<label id='label_fac_".$facID."'>" . $facIDs_facNames[$facID] . "<input type='checkbox' id='fac_".$facID."' onclick='updateSelectedFacility(" . $facID . ")' ";
                    if ($allFacsStatus[$facID] === true) { //meaning that the facility was selected
                        $curElem = $curElem . "checked";
                    } 
                    $curElem = $curElem . "></label>";
                    echo $curElem;
                }
            ?>
        </div>
        <br>

        <input type='date' id='reqDate'>
        <button id='date_button' onclick='checkDate()'>Check this date</button>
        <br>
        <br>
        Fields
        <div id="fields">
             <?php
                
                foreach ($onlyFacsID as $facID) {
                    if ($allFacsStatus[$facID] === true) { //meaning that the facility was selected
                        foreach(($allFacsFields[$facID]) as $fldID) {
                            $curElem = "<label id='label_fld_".$fldID."'>" . $facIDs_facNames[$facID] . "@" . $fldIDs_fldNames[$fldID] . "<input type='checkbox' id='fld_".$fldID."' onclick='updateSelectedField(" . $fldID . ")'";
                            if ($allFldsStatus[$fldID] === true) {
                                
                                
                                $curElem = $curElem . "checked" ;
                            }
                            $curElem = $curElem . "></label>";
                            echo $curElem;

                        }
                    } 
                    
                }
            ?>
        </div>
        
        <div id="availableFields">
            <?php 
                $result = $conn->query($datecollecter);
                // Iterate over each row in the results
                
                while ($row = $result->fetch_assoc())
                {
                    echo "<tr>";
                    echo "<td>" . $row['fld_name'] . "</td>";
                    echo "<td>" . "open" . "</td>";
                    echo "</tr>";
                }
            ?>
        </div>
        <br>
        <br>
        <br>
        <!-- will replace id="availability" -->
        <div id="availableDates">
            <br>
            <table>
                <thead>
                    <tr>
                        <?php
                            $allFlds = array_keys($allFldsStatus);
                            $reqFlds = array();
                            foreach($allFlds as $fldID) {
                                if ($allFldsStatus[$fldID] === true) {
                                    echo "<th>" . $fldIDs_fldNames[$fldID] . "</th>";
                                    array_push($reqFlds, $fldID);
                                }

                            }
                        ?>
                    </tr>
                </thead>
                <?php 
                    
                    $curDate = new DateTime(); //initializes to the current date
                    for ($i = 0; $i < 30; $i++) {
                        $curDate->add(new DateInterval('P'.$i.'D')); // P stands for period; D stands for days
                        
                        echo "<tr>";
                        foreach($reqFlds as $fldID) {
                            // echo json_encode(in_array($curDate->format("Y-m-d"), $allFieldsDates[$fldID]));
                            $dateWasReq = in_array($curDate->format("Y-m-d"), $allFieldsDates[$fldID]);
                            if ($dateWasReq === false || $dateWasReq === null) {
                                echo "<td>" . $curDate->format("Y-m-d") . "</td>";
                            } else {
                                echo "<td>Not available</td>";
                            }
                        }
                        
                        echo "</tr>";

                    }
                    
                ?>
            </table>
        </div>
    </tbody>
    </table>
</body>
</html>


<!-- Notes
Use PHP to store the information
Use PHP to display the information
---This is possible by "echoing" html code
PHP can hold the most up to date information
---This is possible by updating variables when reloading page in php
 -->