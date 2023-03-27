<html lang="en">
<head>
    <?php
        include('library.php');
        if(!isset($id)){
            $id = 1;
        }
        if(!isset($month_id)){
            $month_id = 1;
        }
        if(!isset($day_id)){
            $day_id = 1;
        }
        if(!isset($year_id)){
            $year_id = 1;
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
            

            // 1.) Person selects a field; page will reload
            // 2.) gives us chance to run another sql query
            // 2b.) get the field chosen; see the dates chosen for that field; display date chosen
            
            $sqlRequestedDates = <<<SQL
                SELECT app_date_req, app_fld_id
                FROM applications
                ORDER BY app_fld_id DESC, app_date_req DESC 
                ;
            SQL;
            $sqlRequestedDates = $conn->query($sqlRequestedDates);

            // check if the dates for the selected field
            


            // How can someone in the future use this code to implement the hour-logic:
            // 1.) While accessing the fields and facilities, the times that each facility is accessed may also be requested
            // 2.) With the times requested in an array, javascript can perform the logic needed to display the available
            //      times that the user is allowed to request
        ?>
        <script>
            
            var facilitiesAndFields = <?php echo json_encode($allFacsFields)?>; // key : value (map)
            var onlyFacs = <?php echo json_encode($onlyFacs)?>;

                        
            function loadFacilities() {
                
                // console.log(onlyFacs);
                var facCheckBoxes = $('#facility');
                for (var i = 0; i < onlyFacs.length; i++) {
                    var checkBox = document.createElement('input');
                    checkBox.type = 'checkbox';
                    checkBox.id = 'fac_' + i;
                    // checkBox.name = onlyFacs[i];
                    checkBox.value = onlyFacs[i];
                    checkBox.onclick = loadFields(onlyFacs[i]);
                    

                    facCheckBoxes.append(onlyFacs[i]);
                    facCheckBoxes.append(checkBox);
                    facCheckBoxes.append("<br>");
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





            // Used for drop downs
            // function updateFields(){
            //     var id=$("#facility").val();
            //     window.location.replace('timeCheck.php?id=' + id); //reloads the page; php code executes again
            // }


            function updateTimes(){
                var id=$("#time").val();
                window.location.replace('timeCheck.php?id=' + id);
            }
        </script>
        
        <div class="mb-3">
        <label for="Facility" class="form-label">Facility</label>
        <!-- <select class="form-select" id="facility" onchange="updateFields()" >
            
        </select> -->

        </div>

        <div id="facility">
            
        </div>
        <br>
        <div id = "monthList">
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
        </div>
        <div id="facility">
           

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
