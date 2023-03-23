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

        $first_name = $conn->real_escape_string($first_name);
        $last_name = $conn->real_escape_string($last_name);
        $tier = $conn->real_escape_string($tier);
        $date_requested = $conn->real_escape_string($date_requested);
        $start_time = $conn->real_escape_string($start_time);
        $end_time = $conn->real_escape_string($end_time);
        $description = $conn->real_escape_string($description);
        $estimated_people = $conn->real_escape_string($estimated_people);

        $sql = "INSERT INTO applications(app_cus_first_name, app_cus_last_name, app_tier, app_afl_id, app_date_req, app_start_time, app_end_time, app_desc, app_estim_people)" . 
                "VALUES('$first_name', '$last_name', '$tier', '$afl_id', '$date_requested', '$start_time', '$end_time', '$description', '$estimated_people')";
                
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