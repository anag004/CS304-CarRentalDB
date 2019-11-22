<html>
    <head>
        <title>CPSC 304 Project</title>
    </head>

    <body>
        <!-- A drop down menu listing the car types -->
        <?php
            require "Database.php";

            // Creates a drop-down menu with all the possible car types
            function createCarTypesDropdown($result) {
                echo "<select id='carList'>";

                while ($row = OCI_Fetch_array($result, OCI_BOTH)) {
                    echo "<option value = " . "'" . $row["VTNAME"] . "'>" . $row["VTNAME"] . "</option>";
                }

                echo "</select>";
            }


            $db = new Database();
            $db->connect();
            $result = $db->executePlainSQL("SELECT * FROM vehicle_type");
            createCarTypesDropdown($result);
        ?>
    </body>
</html>