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
<body>
    <table class="table">
    <thead>
        <tr>
            <th>Field Name</th>
            <th>Field Reservation Status</th>
        </tr>
    </thead>
    <tbody>
        <script>
            function updateFields(){
                var id=$("#facility").val();
                window.location.replace('timeCheck.php?id=' + id);
            }
            function updateTimes(){
                var id=$("#time").val();
                window.location.replace('timeCheck.php?id=' + id);

            }
        </script>
        <?php
            $conn = get_database_connection();

             // Build the SELECT statement
             $sql = "SELECT * FROM fields WHERE fld_loc_id=".$id;
     
             // Execute the query and save the results
             $result = $conn->query($sql);

             // Iterate over each row in the results
            while ($row = $result->fetch_assoc())
            {
                echo "<tr>";
                echo "<td>" . $row['fld_name'] . "</td>";
                echo "<td>" . $row['fld_reserved'] . "</td>";
            }
            
        ?>
        <div class="mb-3">
        <label for="Facility" class="form-label">Facility</label>
        <select class="form-select" id="facility" onchange="updateFields()">
            <option value="1"<?php if($id==1)echo "Selected"; ?>>Briggs Field</option>
            <option value="2" <?php if($id==2)echo "Selected"; ?> >Ceurvels Field</option>
            <option value="3"<?php if($id==3)echo "Selected"; ?>>Calvin J. Ellis Field</option>
            <option value="4"<?php if($id==4)echo "Selected"; ?>>Forge Pond Park</option>
            <option value="5"<?php if($id==5)echo "Selected"; ?>>Amos Gallant Field</option>
            <option value="6"<?php if($id==6)echo "Selected"; ?>>B. Everett Hall</option>
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
            <label for="priority" class="field-form-label">Time</label>
            <select id="field" name="priority" onchange="">
                <option value="1">T-Ball</option>
                <option value="2">Full-size Baseball</option>
                <option value="3">Little League</option>
                <option value="4">Softball</option>
                <option value="5">Lacrosse</option>
                <option value="6">Soccer</option>
                <option value="7">Basketball</option>
                <option value="8">Multi-Use Soccer</option>
                <option value="9">Multi-Use Lacrosse</option>
                <option value="10">Multi-Use Other</option>
                <option value="11">Pavilion</option>
                <option value="12">Kitchen & Pavilion</option>
                <option value="13">Football</option>
                <option value="14">Street Hockey Rink</option>
                <option value="15">Other</option>
            </select>
        </div>
    </tbody>
    </table>
</body>
</html>