<html>
<head>
    <title>View Vehicles</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> 

    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Roboto Slab', serif; background-color: #008a9f; ">
    <div class = "row h-100">
        <div class="col-2"></div>
        <div class = "col-8 my-auto">
            <div class="card rounded shadow shadow-sm">
                <div class="card-header">
                <h3 class="mb-0">
                        View Vehicles 
                        <div class="float-right btn btn-info" onclick="window.location.href='../home.php';">
                            Home
                        </div>
                    </h3>
                </div>
                <div class="card-body">
                    <form method="get">
                        <input type = "hidden" name="FETCH_DATA" value="true">
                        <div class="form-group">
                            <label>Car Type:</label> 
                            <?php 
                                require "../Database.php";
                                require "../ProjectUtils.php";
                                $db = new Database();
                                $db->connect();
                                $result = $db->executePlainSQL("SELECT * FROM vehicle_types");
                                echo ProjectUtils::getDropdownString($result,"VTNAME","form-control");
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Location:</label> 
                            
                            <?php 
                                $result = $db->executePlainSQL("SELECT DISTINCT location FROM vehicles"); //fix
                                echo ProjectUtils::getDropdownString($result,"LOCATION","form-control");
                            ?>
                        </div>
                        
                        <div class="form-group">
                            <label>From:</label> 
                            
                            <input type='date' name="FROM_DATE" class="form-control">
                            <input type='time' name="FROM_TIME" class="form-control">
                        </div>
                        <div class="form-group">        
                            <label>To: </label>
                            
                            <input type='date' name="TO_DATE" class="form-control">
                            <input type='time' name="TO_TIME" class="form-control">
                        </div>
                        
                        <input type='submit' value="Search" class="btn btn-info">
                        <input type='button' onclick="window.location.href='./view_vehicles.php'" value="Reset" class="btn btn-info">
                    </form> 
                </div>
                <div class="card-footer">
                    Hello
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
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

            echo "<h3> " . $counter . " vehicles found </h3>";
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