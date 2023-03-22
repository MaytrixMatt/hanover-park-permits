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
    </tbody>
    </table>
</body>
</html>