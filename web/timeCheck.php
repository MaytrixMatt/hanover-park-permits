<html lang="en">
<head>
    <?php
        include('library.php');
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
    <br>
    </tbody>
    </table>
</body>
</html>