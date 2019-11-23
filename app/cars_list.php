<html>
    <head>
        <title>CPSC 304 Project</title>
    </head>

    <body>
        <!-- Lists all the available cars passed to the POST object in a table -->
        <?php
            require "Database.php";

            function extractVehicleTypeName() {
                return $_GET['VTNAME'];
            }

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
                echo "</ul>";

                echo "<h3> " . $counter . " vehicles found </h3><br>";
            }

            $db = new Database();
            $db->connect();
            $vehicleTypeName = extractVehicleTypeName();
            $result = $db->executePlainSQL("SELECT * FROM vehicle WHERE vtname = '" . $vehicleTypeName . "' AND status = 'available' ");
            displayResult($result);
        ?>
    </body>
</html>