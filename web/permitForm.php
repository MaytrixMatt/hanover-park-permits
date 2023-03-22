<!DOCTYPE html>
<html>
    <head> 
        <title>Field Park Permits</title>
        <script src="scripts.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>

    <body> 
        <h1>Apply for Field Permits</h1>

        <form action="permitSubmit.php" method="POST"> 
            First Name:<br/>
            <input type="text" name="first_name" /><br/>

            Last Name:<br/>
            <input type="text" name="last_name" /><br/>

            Tier:<br/>
            <select name="tier">
            <option value="t0">1</option>
            <option value="t1">2</option>
            <option value="t2">3</option>
            <option value="t3">4</option>
            <option value="t4">5</option>
            <option value="t5">6</option>
            <option value="t6">7</option>
            <option value="t7">8</option>
            <option value="t8">9</option>
            </select><br />

            Facility:<br />
            <select name="facility">
            <option value="f1">Briggs Field</option>
            <option value="f2">Ceurvels Field</option>
            <option value="f3">Calvin J. Ellis Field</option>
            <option value="f4">Forge Pond Park</option>
            <option value="f5">Amos Gallant Field</option>
            <option value="f6">B. Everett Hall</option>

            Field Requested:<br />
            <select name="field_requested">
            <option value="f1">Soccer #1</option>
            <option value="f2">Baseball #6</option>
            <option value="f3">Tennis</option>
            <option value="f4">Pavilion</option>
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