<html lang="en">
<head>
    <?php
        include('library.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Checker</title>
</head>
<body>
    <table class="table">
    <thead>
        <tr>
            <th>Field ID</th>
            <th>Field Name</th>
            <th>Field Location ID</th>
            <th>Field Reservation Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $conn = get_database_connection();

             // Build the SELECT statement
             $sql = "SELECT * FROM fields";
     
             // Execute the query and save the results
             $result = $conn->query($sql);

             // Iterate over each row in the results
            while ($row = $result->fetch_assoc())
            {
                echo "<tr>";
                echo "<td>" . $row['fld_id'] . "</td>";
                echo "<td>" . $row['fld_name'] . "</td>";
                echo "<td>" . $row['fld_loc_id'] . "</td>";
                echo "<td>" . $row['fld_reserved'] . "</td>";
            }
            
        ?>
        <div class="mb-3">
        <label for="priority" class="form-label">Facility</label>
        <select class="form-select" name="priority">
            <option value="1">Briggs Field</option>
            <option value="2">Ceurvels Field</option>
            <option value="3">Calvin J. Ellis Field</option>
            <option value="4">Forge Pond Park</option>
            <option value="5">Amos Gallant Field</option>
            <option value="6">B. Everett Hall</option>
        </select>
    </div>
    </tbody>
    </table>
</body>
</html>