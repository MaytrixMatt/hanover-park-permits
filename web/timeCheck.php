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
        // if(!isset($month_id)){
        //     $month_id = 1;
        // }
        // if(!isset($day_id)){
        //     $day_id = 1;
        // }
        // if(!isset($year_id)){
        //     $year_id = 1;
        // }
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
            // fieldsIDs don't start at 1 nor 0!`!!!
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

                //Drop Down Code
                
                // facDropDown.val(<?php echo $id ?>);


                // var curFlds = facilitiesAndFields[onlyFacs[<?php echo $id?> - 1]];
                // var fldDropDown = $('#field');
                // for (var i = 0; i < curFlds.length; i++) {
                    
                //     fldDropDown.append(
                //         $('<option></option>').val(i + 1).html(curFlds[i])
                //     );
                // };
                
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

                        console.log(fldID_fldNames[curFieldID]);
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


            // function updateMonth(){
            //     var month_id=$("#year").val();
            //     window.location.replace('permitForm.php?id=' + id);
            // }
            // function updateDays(){
            //     var day_id=$("#day").val();
            //     window.location.replace('permitForm.php?id=' + id);
            // }
            // function updateYear(){
            //     var year_id=$("#year").val();
            //     window.location.replace('permitForm.php?id=' + id);
            // }

            // function checkDate(){
            //     var reqDate=$("#reqDate").val(); //takes the form of a string YYYY-MM-DD
            //     console.log(reqDate);
                
            //     // Check the fields available for this date
            //     // fieldsAndDates is a map with field id : dates requested

            //     // 1.) find the fields requested
            //     $('#fields').each(function () {
            //         var curElem = $(this);
            //         console.log(curElem.is('input'));
            //     });

            // }
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
        <!-- <div id = "monthList">
            <label for="monthlist" class="field-form-label">Month</label>
            <select id="monthlist" name="monthlist" onchange="updateMonth()">
                <option value="1"<?php if($month_id==1)echo "Selected"; ?>>January</option>
                <option value="2"<?php if($month_id==2)echo "Selected"; ?>>February</option>
                <option value="3"<?php if($month_id==3)echo "Selected"; ?>>March</option>
                <option value="4"<?php if($month_id==4)echo "Selected"; ?>>April</option>
                <option value="5"<?php if($month_id==5)echo "Selected"; ?>>May</option>
                <option value="6"<?php if($month_id==6)echo "Selected"; ?>>June</option>
                <option value="7"<?php if($month_id==7)echo "Selected"; ?>>July</option>
                <option value="8"<?php if($month_id==8)echo "Selected"; ?>>August</option>
                <option value="9"<?php if($month_id==9)echo "Selected"; ?>>September</option>
                <option value="10"<?php if($month_id==10)echo "Selected"; ?>>October</option>
                <option value="11"<?php if($month_id==11)echo "Selected"; ?>>November</option>
                <option value="12"<?php if($month_id==12)echo "Selected"; ?>>December</option>
            </select>
        



            <label for="priority" class="day-form-label">Day</label>
            <select id="day" name="priority" onchange = "updateDays()">
                <option value="1"<?php if($day_id==1)echo "Selected"; ?>>1</option>
                <option value="2"<?php if($day_id==2)echo "Selected"; ?>>2</option>
                <option value="3"<?php if($day_id==3)echo "Selected"; ?>>3</option>
                <option value="4"<?php if($day_id==4)echo "Selected"; ?>>4</option>
                <option value="5"<?php if($day_id==5)echo "Selected"; ?>>5</option>
                <option value="6"<?php if($day_id==6)echo "Selected"; ?>>6</option>
                <option value="7"<?php if($day_id==7)echo "Selected"; ?>>7</option>
                <option value="8"<?php if($day_id==8)echo "Selected"; ?>>8</option>
                <option value="9"<?php if($day_id==9)echo "Selected"; ?>>9</option>
                <option value="10"<?php if($day_id==10)echo "Selected"; ?>>10</option>
                <option value="11"<?php if($day_id==11)echo "Selected"; ?>>11</option>
                <option value="12"<?php if($day_id==12)echo "Selected"; ?>>12</option>
                <option value="13"<?php if($day_id==13)echo "Selected"; ?>>13</option>
                <option value="14"<?php if($day_id==14)echo "Selected"; ?>>14</option>
                <option value="15"<?php if($day_id==15)echo "Selected"; ?>>15</option>
                <option value="16"<?php if($day_id==16)echo "Selected"; ?>>16</option>
                <option value="17"<?php if($day_id==17)echo "Selected"; ?>>17</option>
                <option value="18"<?php if($day_id==18)echo "Selected"; ?>>18</option>
                <option value="19"<?php if($day_id==19)echo "Selected"; ?>>19</option>
                <option value="20"<?php if($day_id==20)echo "Selected"; ?>>20</option>
                <option value="21"<?php if($day_id==21)echo "Selected"; ?>>21</option>
                <option value="22"<?php if($day_id==22)echo "Selected"; ?>>22</option>
                <option value="23"<?php if($day_id==23)echo "Selected"; ?>>23</option>
                <option value="24"<?php if($day_id==24)echo "Selected"; ?>>24</option>
                <option value="25"<?php if($day_id==25)echo "Selected"; ?>>25</option>
                <option value="26"<?php if($day_id==26)echo "Selected"; ?>>26</option>
                <option value="27"<?php if($day_id==27)echo "Selected"; ?>>27</option>
                <option value="28"<?php if($day_id==28)echo "Selected"; ?>>28</option>
                <option value="29"<?php if($day_id==29)echo "Selected"; ?>>29</option>
                <option value="30"<?php if($day_id==30)echo "Selected"; ?>>30</option>
                <option value="31"<?php if($day_id==31)echo "Selected"; ?>>31</option>
            </select>
            <label for="yearlist" class="year-form-label">Year</label>
            <select id="yearlist" name="yearlist" onchange="updateYear()">
                <option value="1"<?php if($year_id==1)echo "Selected"; ?>>2023</option>
                <option value="2"<?php if($year_id==2)echo "Selected"; ?>>2024</option>
            </select>
        </div> -->
        <!-- <div id = "fieldList">
            <label for="priority" class="field-form-label">Field</label>
            <select id="field" name="priority" onchange="">
            </select>
        </div> -->
        <br>
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

