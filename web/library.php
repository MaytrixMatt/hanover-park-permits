<?php

/*************************************************************************************************
 * library.php
 *
 * Common environment settings and functions used througout the Ticket Tracker application.
 *************************************************************************************************/

extract($_REQUEST);

/*
 * Returns the content to be included based on the 'content' request parameter, if present.
 */
function get_content()
{
    global $content;

    if (!isset($content))
    {
        $content = 'list';
    }

    $content = 'ticket' . ucfirst(strtolower($content));

    return $content;
}

/*
 * Returns a connection to the underlying MySQL database.
 */
function get_database_connection()
{
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "helpdesk";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}