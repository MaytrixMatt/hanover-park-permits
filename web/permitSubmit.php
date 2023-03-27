<?php

include('library.php');

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Permit Application</title>
    </head>

    <body>
        <h1>Thank you for submitting your permit request.</h1>

        <?php

        extract($_REQUEST);

        $conn = get_database_connection();

        // I don't know if we need lines 22-29, since this site won't be public we shouldn't worry about SQL injection / Cross-site Scripting
        $first_name = $conn->real_escape_string($first_name);
        $last_name = $conn->real_escape_string($last_name);
        $tier = $conn->real_escape_string($tier);
        $date_requested = $conn->real_escape_string($date_requested);
        $description = $conn->real_escape_string($description);
        $estimated_people = $conn->real_escape_string($estimated_people);

        $sql = "INSERT INTO applications(app_cus_first_name, app_cus_last_name, app_tier, app_afl_id, app_date_req, app_description, app_estimated_people)" . 
                "VALUES('$first_name', '$last_name', '$tier', '$afl_id', '$date_requested', '$description', '$estimated_people')";
                
        $conn->query($sql);

        if ($conn->query($sql) == TRUE)
        {
            header('Location: permitForm.php?content=list');
        }
        else
        {
            echo 'Error inserting record: ' . $conn->error;
        }
        
        $conn->close();
        ?>
        <!-- try echoing js code after you query the database; the js code stores values stored in php variables -->
        <p><a href ="permitForm.php">Enter another ticket</a></p>
    </body>

</html>
