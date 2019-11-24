<html>
    <head>
        <title>Reservation Successful!</title>
    </head>
    <body>
        <h3> Congrats! You have reserved a new car </h3>
        <?php
            require "../Database.php";
            require "../ProjectUtils.php";
            
            $db = new Database();
            $db->connect();

            // Find a reservation object
            $result = $db->executePlainSQL("SELECT * FROM reservations WHERE conf_no = '" . $_GET['CONF_NO'] . "'");

            // Print this reservation object
            if (($row = oci_fetch_row($result)) != false) {
                echo "<ul>";
                    echo "<li>CONFIRMATION NUMBER: " . $row[0];
                    echo "<li>VEHICLE TYPE: " . $row[1];
                    echo "<li>DRIVER'S LICENSE NUMBER: " . $row[2];
                    echo "<li>BEGIN DATE/TIME: " . $row[3];
                    echo "<li>END DATE/TIME: " . $row[4];
                echo "</ul>";
            } else {
                echo "Invalid reservation conf_no<br>";
            }
        ?>
    </body>
</html>