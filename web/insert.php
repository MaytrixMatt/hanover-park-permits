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

//extract($_REQUEST);

$conn = get_database_connection();

$problem = $conn->real_escape_string($problem);
$contactEmail = $conn->real_escape_string($contactEmail);

// Build the INSERT statement
$sql = <<<SQL
INSERT INTO tickets (cus_first_name, cus_last_name, tier, afl_id, date_req, start_time, end_time, description)
       VALUES ('{$problem}', $priority, '{$contactEmail}')
SQL;

// Execute the query and redirect to the list
if ($conn->query($sql) == TRUE)
{
    header('Location: index.php?content=list');
}
else
{
    echo "Error inserting record: " . $conn->error;
}

$conn->close();