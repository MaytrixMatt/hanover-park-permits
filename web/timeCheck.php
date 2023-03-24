<html lang="en">
<head>
    <?php
        include('library.php');
        if(!isset($id)){
            $id = 1;
        }
        
        
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Time Checker</title>
</head>
<body onload="loadFacsFields()">
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
                    SELECT fld_id, fld_loc_id, fld_name, loc_name
                    FROM fields
                    JOIN location ON loc_id = fld_loc_id;
                    SQL;
            $resultFacilitiesAndFields = $conn->query($sqlFacilitiesAndFields);
            
            $allFacsFields = array();
            $onlyFacs = array();
             // Iterate over each row in the results
            $curFac = '';
            $curFacFields = array();
            while ($row = $resultFacilitiesAndFields->fetch_assoc())
            {
                if ($curFac != $row['loc_name'])
                {
                    if ($curFac != '') 
                    {
                        $allFacsFields[$curFac] = $curFacFields;
                        $curFacFields = array_diff($curFacFields, $curFacFields);                      
                    }
                    
                    $curFac = $row['loc_name'];
                    // echo $curFac;
                    array_push($onlyFacs, $curFac);
                }
                array_push($curFacFields, $row['fld_name']);
                
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
            
            // How can someone in the future use this code to implement the hour-logic:
            // 1.) While accessing the fields and facilities, the times that each facility is accessed may also be requested
            // 2.) With the times requested in an array, javascript can perform the logic needed to display the available
            //      times that the user is allowed to request
        ?>
        <script>
            
            var facilitiesAndFields = <?php echo json_encode($allFacsFields)?>;
            var onlyFacs = <?php echo json_encode($onlyFacs)?>;

                        
            function loadFacsFields() {
                
                // console.log(onlyFacs);
                var facDropDown = $('#facility');
                for (var i = 0; i < onlyFacs.length; i++) {
                    
                    facDropDown.append(
                        $('<option></option>').val(i + 1).html(onlyFacs[i])
                    );
                }
                facDropDown.val(<?php echo $id ?>);


                var curFlds = facilitiesAndFields[onlyFacs[<?php echo $id?> - 1]];
                var fldDropDown = $('#field');
                for (var i = 0; i < curFlds.length; i++) {
                    
                    fldDropDown.append(
                        $('<option></option>').val(i + 1).html(curFlds[i])
                    );
                };
            }



            function updateFields(){
                var id=$("#facility").val();
                window.location.replace('timeCheck.php?id=' + id); //reloads the page; php code executes again
            }
            function updateTimes(){
                var id=$("#time").val();
                window.location.replace('timeCheck.php?id=' + id);

            }
        </script>
        
        <div class="mb-3">
        <label for="Facility" class="form-label">Facility</label>
        <select class="form-select" id="facility" onchange="updateFields()" >
            
        </select>
        </div>
        <br>
        <div id = "timeList">
            <label for="priority" class="time-form-label">Time</label>
            <select id="time" name="priority" onchange="updateTimes()">
                <option value="0"<?php if($id==1)echo "Selected"; ?>>12:00 AM</option>
                <option value="1"<?php if($id==2)echo "Selected"; ?>>1:00 AM</option>
                <option value="2"<?php if($id==3)echo "Selected"; ?>>2:00 AM</option>
                <option value="3"<?php if($id==4)echo "Selected"; ?>>3:00 AM</option>
                <option value="4"<?php if($id==5)echo "Selected"; ?>>4:00 AM</option>
                <option value="5"<?php if($id==6)echo "Selected"; ?>>5:00 AM</option>
                <option value="6"<?php if($id==7)echo "Selected"; ?>>6:00 AM</option>
                <option value="7"<?php if($id==8)echo "Selected"; ?>>7:00 AM</option>
                <option value="8"<?php if($id==9)echo "Selected"; ?>>8:00 AM</option>
                <option value="9"<?php if($id==10)echo "Selected"; ?>>9:00 AM</option>
                <option value="10"<?php if($id==11)echo "Selected"; ?>>10:00 AM</option>
                <option value="11"<?php if($id==12)echo "Selected"; ?>>11:00 AM</option>
                <option value="12"<?php if($id==13)echo "Selected"; ?>>12:00 PM</option>
                <option value="13"<?php if($id==14)echo "Selected"; ?>>1:00 PM</option>
                <option value="14"<?php if($id==15)echo "Selected"; ?>>2:00 PM</option>
                <option value="15"<?php if($id==16)echo "Selected"; ?>>2:00 PM</option>
                <option value="16"<?php if($id==17)echo "Selected"; ?>>4:00 PM</option>
                <option value="17"<?php if($id==18)echo "Selected"; ?>>5:00 PM</option>
                <option value="18"<?php if($id==19)echo "Selected"; ?>>6:00 PM</option>
                <option value="19"<?php if($id==20)echo "Selected"; ?>>7:00 PM</option>
                <option value="20"<?php if($id==21)echo "Selected"; ?>>8:00 PM</option>
                <option value="21"<?php if($id==22)echo "Selected"; ?>>9:00 PM</option>
                <option value="22"<?php if($id==23)echo "Selected"; ?>>10:00 PM</option>
                <option value="23"<?php if($id==24)echo "Selected"; ?>>11:00 PM</option>
            </select>
        </div>
        <div id = "fieldList">
            <label for="priority" class="field-form-label">Field</label>
            <select id="field" name="priority" onchange="">
            </select>
        </div>
    </tbody>
    </table>
</body>
</html>