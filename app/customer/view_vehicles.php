<html>
<head><title>View Vehicles</title></head>
<body>
    <h3>View Vehicles</h3>
    <form method="get">
    <input type = "hidden" name="FETCH_DATA" value="true">
    <br>
        Car Type: 
        <br>
        <?php 
            require "../Database.php";
            require "../ProjectUtils.php";

            $db = new Database();
            $db->connect();
            $result = $db->executePlainSQL("SELECT * FROM vehicle_types");
            echo ProjectUtils::getDropdownString($result,"VTNAME");
        ?>
        <br>
        <br>
        Location: 
        <br>
        <?php 
            $result = $db->executePlainSQL("SELECT DISTINCT location FROM vehicles"); //fix
            echo ProjectUtils::getDropdownString($result,"LOCATION");
        ?>
        <br>
        <br>
        From: 
        <br>
        <input type='date' name="FROM_DATE">
        <input type='time' name="FROM_TIME">
        <br>
        <br>
        To: 
        <br>
        <input type='date' name="TO_DATE">
        <input type='time' name="TO_TIME">
        <br>
        <br>
        <input type='submit' value="Search">
        <input type='button' onclick="window.location.href='./view_vehicles.php'" value="Reset">
        <hr>
    </form> 
    <?php
        // Prints the result in an HTML table
        function displayResult($result) {
            $counter = 0;

            echo "<h2> Available vehicles: </h2>";
            echo "<table border = '1'>";
            echo "<tr><th>SNO</th><th>VLICENSE</th><th>MAKE</th><th>YEAR</th><th>COLOR</th><th>ODOMETER</th><th>STATUS</th><th>VTNAME</th><th>LOCATION</th><th>CITY</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                $counter++;
                echo "<tr>";
                echo "<td>" . $counter . "</td>";
                echo "<td>" . $row["VLICENSE"] . "</td>";
                echo "<td>" . $row["MAKE"] . "</td>";
                echo "<td>" . $row["YEAR"] . "</td>";
                echo "<td>" . $row["COLOR"] . "</td>";
                echo "<td>" . $row["ODOMETER"] . "</td>";
                echo "<td>" . $row["STATUS"] . "</td>";
                echo "<td>" . $row["VTNAME"] . "</td>";
                echo "<td>" . $row["LOCATION"] . "</td>";
                echo "<td>" . $row["CITY"] . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";

            echo "<h3> " . $counter . " vehicles found </h3><br>";
        }
        
        if ($_GET['FETCH_DATA'] == "true") {
            $queryString = "SELECT * FROM vehicles v" . ProjectUtils::getVehicleQueryString($_GET);
            if (!$queryString) {
                echo "ERROR: Invalid request for vehicle list";
            } else {
                $result = $db->executePlainSQL($queryString);
                displayResult($result);
            }
        }
    ?>
</body>
</html> 