<!DOCTYPE html>
<html>
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
        
    ?>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <title>Field Park Permits</title>
        <script src="scripts.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>

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
                    // echo "updating: " . $updatedFac . " to " . $updatedFacStatus;
                }
                $_SESSION['allFacsStatus'] = $allFacsStatus;
            }
            
            // echo json_encode($_SESSION['allFacsStatus']);


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

            function updateSelectedFacility(facID) {
                // console.log("This facility ID was loaded: " + facID);
                
                // var fieldCheckBoxes = $('#fields');
                
                var allFacsStatus = <?php echo json_encode($allFacsStatus)?>; 
                console.log(allFacsStatus);
                console.log(facID);


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
                window.location.replace("permitForm.php?updatedFac=" + facID + "&" + "updatedFacStatus=" + facCheckboxStatus); //***must use json_decode(allFacsStatus) before use 

            }


            function updateSelectedField(fldID) {
                var allFldsStatus = <?php echo json_encode($allFldsStatus)?>; 
                console.log(allFldsStatus);
                console.log(fldID);

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
                

                window.location.replace("permitForm.php?updatedFld=" + fldID + "&" + "updatedFldStatus=" + fldCheckboxStatus + "&" + "reqDate=" + reqDate); //***must use json_decode(allFacsStatus) before use 
            }

            function checkDate(){
                var reqDate=$("#reqDate").val();
                window.location.replace('permitForm.php?reqDate=' + reqDate);
            }

        </script>
    <body> 
        <style>
            label {
                display: block;
            }
            input {
                display: inline-block;
            }
        </style>
        

        <div class = "application">
            <h1>Apply for Field Permits</h1>

            <form action="permitSubmit.php" method="POST"> 
                First Name:<br/>
                <input type="text" name="first_name" /><br/>

                Last Name:<br/>
                <input type="text" name="last_name" /><br/>

                Tier:<br/>
                <select name="tier">
                <option value="0">1</option>
                <option value="1">2</option>
                <option value="2">3</option>
                <option value="3">4</option>
                <option value="4">5</option>
                <option value="5">6</option>
                <option value="6">7</option>
                <option value="7">8</option>
                <option value="8">9</option>
                </select><br />

                <h2>
                    Facility:

                </h2>
                <br />
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
                <!-- <select id="facility">
                <option value="1">Briggs Field</option>
                <option value="2">Ceurvels Field</option>
                <option value="3">Calvin J. Ellis Field</option>
                <option value="4">Forge Pond Park</option>
                <option value="5">Amos Gallant Field</option>
                <option value="6">B. Everett Hall</option> -->

                <br>
                <br>
                <h2>
                    Field Requested:
                </h2>
                <br />
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
                <!-- <select id="field_requested">
                </select><br /> -->

                Date Requested:<br/>
                <input type='date' id='reqDate' name='date_requested'>
                <input type='checkbox' id='date_button' onclick='checkDate()'>


                Description of Activity:<br/>
                <input type="text" name="description" /><br/>

                Estimated People Attending:<br/>
                <input type="text" name="estimated_people" value = "0"/><br/>

                <br>
                <input type="submit" /><br/>
                <br>

            </form>
        </div>

        <div class = "availability" width = 50px height = 100px float = right>
            <h1>Availability</h1>
            <table>
                <div id="availableFields">
                    <?php 
                        $result = $conn->query($datecollecter);
                        // Iterate over each row in the results
                        
                        while ($row = $result->fetch_assoc())
                        {
                            echo json_encode($row);
                            echo "<tr>";
                            echo "<td>" . $facIDs_facNames[$row['afl_loc_id']] . " @ " . $row['fld_name'] . "</td>";
                            echo "<td>" . "open" . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </div>

            </table>
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
                        
                        $curDate = new DateTime($reqDate); //initializes to the current date
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
        <!-- <table class="table">
        <thead>
            <tr>
                <th>Field Name</th>
                <th>Field Reservation Status</th>
            </tr>
        </thead> -->
        </div>

    </body>
</html>
