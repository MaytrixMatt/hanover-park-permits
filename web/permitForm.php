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
            <option value=0>1</option>
            <option value=1>2</option>
            <option value=2>3</option>
            <option value=3>4</option>
            <option value=4>5</option>
            <option value=5>6</option>
            <option value=6>7</option>
            <option value=7>8</option>
            <option value=8>9</option>
            </select><br />

            Field Requested:<br/>
            <select name="field_requested">
            <option value="volvo">Soccer #1</option>
            <option value="saab">Baseball #6</option>
            <option value="mercedes">Tennis</option>
            <option value="audi">Pavilion</option>
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