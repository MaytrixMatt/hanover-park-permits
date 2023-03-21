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

        $sql = "INSERT INTO applications(app_cus_first_name, app_cus_last_name, app_tier, app_date_req, app_start_time, app_end_time, app_desc, app_estim_people)" . 
                "VALUES('$first_name', '$last_name', '$tier', '$date_requested', '$start_time', '$end_time', '$description', '$estimated_people')";
                
        $conn->query($sql);

        ?>

        <p><a href ="permitForm.php">Enter another ticket</a></p>
    </body>

</html>