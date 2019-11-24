<html>
<head>
    <title>Rent Vehicles</title>
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
        <div class="col-md-2"></div>
        <div class = "col-md-8 mt-5 mb-5">
            <div class="card rounded shadow shadow-sm">
                <div class="card-header">
                <h3 class="mb-0">
                        Rent Vehicles 
                        <div class="float-right btn btn-info" onclick="window.location.href='../home.php';">
                            Home
                        </div>
                    </h3>
                </div>
                <div class="card-body">
                        <?php
                            require "../Database.php";
                            require "../ProjectUtils.php";

                            $db = new Database();
                            $db->connect();

                            // Code for renting a vehicle   
                            // Check if a POST request is sent 
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                // Declare necessary variables
                                $reservation = false;
                                $confNo = null;
                                $datetime_format = "'YYYY-MM-DD:HH:MI'";

                                // Check if the confirmation number is given 
                                if (!isset($_POST['CONF_NO']) || $_POST['CONF_NO'] == "") {
                                    echo "CONF_NO NOT GIVEN<br>";
                                    // Look at the other data to make a reservation and link to the rental
                                    $confNo = ProjectUtils::makeReservation($_POST, $db);

                                    // Retrieve the reservation object and set variales
                                    $reservation = ProjectUtils::getReservation($confNo, $db, "*");
                                } else {
                                    // Find the reservation and set variables
                                    $reservation = ProjectUtils::getReservation($_POST['CONF_NO'], $db, "VTNAME, to_char(FROM_DATETIME, " . $datetime_format . ") AS FROM_DATETIME, to_char(TO_DATETIME, " . $datetime_format . ") AS TO_DATETIME, VTNAME, LOCATION");
                                    $confNo = $_POST['CONF_NO'];
                                }

                                var_dump($reservation);

                                if ($reservation) {
                                    // Find a vehicle with the given type and license between the given dates
                                    $queryString = "SELECT * FROM vehicles v WHERE NOT EXISTS ( ";
                                    $queryString .= "SELECT * FROM rentals rent, reservations resv WHERE ";
                                    $queryString .= "(to_date('" . $reservation['FROM_DATETIME'] . "', " . $datetime_format . "), to_date('" . $reservation['TO_DATETIME'] . "', " . $datetime_format . ")) ";
                                    $queryString .= "OVERLAPS (resv.FROM_DATETIME, resv.TO_DATETIME) ";
                                    $queryString .= " AND resv.conf_no = rent.conf_no AND rent.vlicense = v.vlicense )";
                                    $queryString .= " AND vtname = '" . $reservation['VTNAME'] . "'";
                                    $queryString .= " AND location = '" . $reservation['LOCATION'] . "'";

                                    $result = $db->executePlainSQL($queryString);

                                    // Check if a vehicle exists in this duration
                                    if (($vehicle = oci_fetch_array($result)) != false) {

                                        // Create the rental with the details
                                        $vlicense = $vehicle['VLICENSE'];
                                        $odometer = $vehicle['ODOMETER'];       
                                        $card_name = $_POST['CARD_NAME'];
                                        $card_no = $_POST['CARD_NO'];
                                        $date_format = "YYYY-MM-DD";
                                        $exp_date = "to_date('" . $_POST['EXP_DATE'] . "', '" . $date_format . "')";
                                        $rid = hash('ripemd160', $dlicense . $to_datetime . $from_datetime . $vlicense);

                                        echo "DLICENSE: " . $dlicense . "<br>";

                                        // Create the rental
                                        $queryString = "INSERT INTO rentals VALUES('" . $rid . "', " . $vlicense . ", " . $odometer . ", '" . $card_name . "', " . $card_no . ", " . $exp_date . ", '" . $confNo . "')";
                                        $db->executePlainSQL($queryString);
                                        $db->commit();

                                        // Redirect to the view rentals page
                                        header("Location: view_rentals.php?RID=" . $rid . "&CONF_NO=" . $confNo);
                                    } else {
                                        echo ProjectUtils::getErrorBox("No available cars.");
                                    }

                                } else {
                                    echo ProjectUtils::getErrorBox("Invalid confirmation number");
                                }
                            }
                        ?>
                    <form method="post">
                        <input type = "hidden" name="FETCH_DATA" value="true">
                        <div class="form-group">
                            <label>Confirmation Number</label>
                            <input type="text" name="CONF_NO" pattern="[0-9]*" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Car Type:</label> 
                            <?php 
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
                        <div class="form-group">
                            <label>Driver's License Number:</label> 
                            <input type='tel' name="DLICENSE" pattern="[0-9]*" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Card Name:</label>
                            <input type="text" name="CARD_NAME" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Card Number:</label>
                            <input type="text" name="CARD_NO" pattern="[0-9]*" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Card Expiry Date:</label>
                            <input type='date' name="EXP_DATE" class="form-control">
                        </div>
                        <input type='submit' value="Rent Vehicle" class="btn btn-info">
                        <input type='button' onclick="window.location.href='./rent_vehicles.php'" value="Reset" class="btn btn-info">
                    </form> 
                </div>
                <div class="card-footer">
        
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

    
</body>
</html> 