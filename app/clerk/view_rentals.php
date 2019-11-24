<html>
    <head>
        <title>Rental Successful!</title>
    </head>
    <body>
        <h3> You have rented a new car </h3>
        <?php
            require "../Database.php";
            require "../ProjectUtils.php";
            
            $db = new Database();
            $db->connect();

            // Find a rental object
            $rentalResult = $db->executePlainSQL("SELECT * FROM rentals WHERE rid = '" . $_GET['RID'] . "'");
            
            // Find the corresponding reservation
            $reservationResult = $db->executePlainSQL("SELECT * FROM reservations WHERE conf_no = '" . $_GET['CONF_NO'] . "'");

            // Print this rental object
            if (($rental = oci_fetch_array($rentalResult)) != false && ($reservation = oci_fetch_array($reservationResult)) != false) {
                echo "<ul>";
                    echo "<li>RENTAL ID: " . $rental['RID'];
                    echo "<li>VEHICLE LICENSE NO: " . $rental['VLICENSE'];
                    echo "<li>DRIVER'S LICENSE NUMBER: " . $reservation['DLICENSE'];
                    echo "<li>LOCATION: " . $reservation['LOCATION'];
                echo "</ul>";
            } else {
                echo "Invalid rental ID<br>";
            }
        ?>
    </body>
</html>