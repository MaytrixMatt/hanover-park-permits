<?php

/*************************************************************************************************
 * insert.php
 *
 * Page to insert (save) a single ticket. This page expects the following request paramaters to
 * be set:
 *
 * - cus_first_name
 * - cus_last_name
 * - tier
 * - field_name (must convert to afl_id)
 * - date_req
 * - start_time
 * - end_time
 * - description
 * - estimated_people
 *************************************************************************************************/

include('library.php');


$conn = get_database_connection();

$sql = <<<SQL
INSERT INTO tickets (cus_first_name, cus_last_name, tier, afl_id, date_req, start_time, end_time, description)
VALUES('$first_name', '$last_name', '$tier', '$date_requested', '$start_time', '$end_time', '$description');
SQL;

if ($conn->query($sql) == TRUE)
{
    header('Location: index.php?content=');
}
else
{
    echo "Error inserting record: " . $conn->error;
}

$conn->close();