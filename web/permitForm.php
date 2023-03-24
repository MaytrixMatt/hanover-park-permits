<!DOCTYPE html>


<html>
    <head> 
        <title>Field Park Permits</title>
        <script src="scripts.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>

    <?php
        include('library.php');
        $sql = <<<SQL
        select fld_id, fld_loc_id, fld_name, loc_name
          from fields
          join location on loc_id = fld_loc_id;
        SQL;
        
        $conn = get_database_connection();
        $result = $conn->query($sql);
<<<<<<< HEAD
        $result->fetch_assoc();
=======
        //echo $result->fetch_assoc();
>>>>>>> 59e60759dc3df8362b73fc1d555ac8e1704aba1e
    ?>

    <body> 
        <h1>Apply for Field Permits</h1>

        <form action="permitSubmit.php" method="POST"> 
            First Name:<br/>
            <input type="text" name="first_name" /><br/>

            Last Name:<br/>
            <input type="text" name="last_name" /><br/>

            Tier:<br/>
            <select name="tier">
            <option value="0">1</option>
            <option value="1">2</option>
            <option value="2">3</option>
            <option value="3">4</option>
            <option value="4">5</option>
            <option value="5">6</option>
            <option value="6">7</option>
            <option value="7">8</option>
            <option value="8">9</option>
            </select><br />

            Facility:<br />
            <select id="facility">
            <option value="1">Briggs Field</option>
            <option value="2">Ceurvels Field</option>
            <option value="3">Calvin J. Ellis Field</option>
            <option value="4">Forge Pond Park</option>
            <option value="5">Amos Gallant Field</option>
            <option value="6">B. Everett Hall</option>

            Field Requested:<br />
            <select id="field_requested">
            </select><br />

            Date Requested:<br/>
            <input type="date" name="date_requested" /><br/>

            Start Time:<br/>
            <input type="time" name="start_time" /><br/>

            End Time:<br/>
            <input type="time" name="end_time" /><br/>

            Description of Activity:<br/>
            <input type="text" name="description" /><br/>

            Estimated People Attending:<br/>
            <input type="text" name="estimated_people" /><br/>

            <br>
            <input type="submit"/><br/>

        </form>

    </body>

</html>