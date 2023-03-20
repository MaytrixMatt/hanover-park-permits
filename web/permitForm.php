<!DOCTYPE html>
<html>
    <head> 
        <title>Field Park Permits</title>
    </head>

    <body> 
        <h1>Apply for Field Permits</h1>

        <form action="permitSubmit.php" method="POST"> 
            First Name:<br/>
            <input type="text" name="first_name" /><br/>

            Last Name:<br/>
            <input type="text" name="last_name" /><br/>

            Tier:<br/>
            <input type="text" name="tier" /><br/>

            Field Requested:<br/>
            <input type="text" name="field_requested" /><br/>

            Date Requested:<br/>
            <input type="text" name="date_requested" /><br/>

            Start Time:<br/>
            <input type="text" name="start_time" /><br/>

            End Time:<br/>
            <input type="text" name="end_time" /><br/>

            Description of Activity:<br/>
            <input type="text" name="description" /><br/>

            Estimated People Attending:<br/>
            <input type="text" name="estimated_people" /><br/>

            <br>
            <input type="submit"/><br/>

        </form>

    </body>

</html>