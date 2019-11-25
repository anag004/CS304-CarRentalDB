<html>
<head>
    <title>Return Vehicles</title>
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
                        Return Vehicles 
                        <div class="float-right btn btn-info btn-sm" onclick="window.location.href='../home.php';">
                            Home
                        </div>
                    </h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type = "hidden" name="FETCH_DATA" value="true">
                        <div class="form-group">
                            <label>Rental ID:</label>
                            <input type="text" name="rid" class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <label>Return Time:</label> 
                                <input type='date' name="date" class="form-control" required="true">
                                <input type='time' name="time" class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <label>Odometer:</label> 
                            <input type='text' name="odometer" pattern="[0-9]*" class="form-control" required="true">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="tank" value="full">
                            <label class="form-check-label">Fuel Tank Full</label>
                        </div>
                        <br>
                        <input type='submit' value="Return Vehicle" class="btn btn-info btn-sm">
                        <input type='button' onclick="window.location.href='./return_vehicles.php'" value="Reset" class="btn btn-info btn-sm">
                    </form> 
                </div>
                <div class="card-footer">
                     
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <?php
        require "../Database.php";
        require "../ProjectUtils.php";

        $db = new Database();
        $db->connect();

        // Find the corresponding rental object
        $rid = $_POST['rid'];
        $date_format = 'YYYY-MM-DD:HH24:MI';
        $rental = getRental($rid);
        $final_dist = $_POST['odometer'];
        
        if ($rental) {
            // Attempt to find a return object with the same rid as this
            $returnCheck = getReturn($_POST['rid']);
            if ($returnCheck) {
                echo ProjectUtils::getErrorBox("The car with rid " . $_POST['rid'] . " has already been returned.");
            } else {
                // Get the vehicle object
                $vehicle = getVehicle($rental['VLICENSE']);
                $vtype = getVehicleType($vehicle['VTNAME']);
                $initial_dist = $vehicle['ODOMETER'];
                $initial_date = "'" . $rental['FROM_DATETIME'] . "'";
                $final_date = "'" . $_POST['date'] . ":" . $_POST['time'] . "'";

                // Do the cost calculation =====
                $rentalCost = 0; 

                // Weekly charges
                $numWeeks = (int)($diffHours / (7 * 24));
                $wrate = $vtype['WRATE'];
                $weeklyCost = $wrate * $numWeeks;
                $diffHours -= $numWeeks * (7 * 24);
                $rentalCost += $weeklyCost;
                
                // Daily charges
                $numDays = (int)($diffHours / 24);
                $drate = $vtype['DRATE'];
                $dailyCost = $drate * $numDays;
                $diffHours -= $numDays * 24;
                $rentalCost += $dailyCost;

                // Hourly charges
                $numHours = $diffHours;
                $hrate = $vtype['HRATE'];
                $hourlyCost = $hrate * $numHours;
                $diffHours -= $numHours;
                $rentalCost += $dailyCost;

                $insuranceCost = 0;

                // Weekly charges
                $wirate = $vtype['WIRATE'];
                $weeklyCost = $wirate * $numWeeks;
                $insuranceCost += $weeklyCost;
                
                // Daily charges
                $dirate = $vtype['DIRATE'];
                $dailyCost = $dirate * $numDays;
                $insuranceCost += $dailyCost;

                // Hourly charges
                $hirate = $vtype['HIRATE'];
                $hourlyCost = $hirate * $numHours;
                $insuranceCost += $dailyCost;

                $distance = $final_dist - $initial_dist;
                $krate = $vtype['KRATE'];
                $kCost = $krate * $distance;
            
                $totalCost = $rentalCost + $insuranceCost + $kCost;
                
                $fullTank = "";
                if ($_POST['tank'] == 'full') {
                    $fullTank = "y";
                } else {
                    $fullTank = "n";
                }

                // Insert the return entry into the db
                $queryString = "INSERT INTO returns VALUES('$rid', to_date($final_date, '$date_format'), $final_dist, '$fullTank', $totalCost)";
                $db->executePlainSQL($queryString);
                $db->commit();

                // Update the odometer reading of the vehicle
                $vlicense = $vehicle['VLICENSE'];
                $queryString = "UPDATE vehicles SET odometer = $final_dist WHERE vlicense = $vlicense";
                $db->executePlainSQL($queryString);
                $db->commit();

                // Get the difference between dates in hours
                $diffHours = getDateDifference($initial_date, $final_date);
                $vtname = $vehicle['VTNAME'];

                // Pass it to the sucess page
                header("Location: view_return.php?DIFF=$diffHours&DISTANCE=$distance&VTYPE=$vtname");
            }
        } else {
            echo ProjectUtils::getErrorBox("There is no rental with ID $rid");
        }

        function getReturn($rid) {
            global $db, $date_format;

            $queryString = "SELECT * FROM returns WHERE rid = '$rid'";
            $result = $db->executePlainSQL($queryString);

            if (($rental = oci_fetch_array($result))) {
                return $rental; 
            } else {
                return false;
            }
        }

        function getRental($rid) {
            global $db, $date_format;

            $queryString = "SELECT rent.vlicense, to_char(res.from_datetime, '$date_format') as from_datetime FROM rentals rent, reservations res WHERE res.conf_no = rent.conf_no AND rent.rid = '$rid'";
            $result = $db->executePlainSQL($queryString);

            if (($rental = oci_fetch_array($result))) {
                return $rental; 
            } else {
                return false;
            }
        }

        function getVehicleType($vtname) {
            global $db;

            $queryString = "SELECT * FROM vehicle_types WHERE vtname = '$vtname'";
            $result = $db->executePlainSQL($queryString);

            if (($vehicle_type = oci_fetch_array($result))) {
                return $vehicle_type; 
            } else {
                return false;
            }
        }

        function getVehicle($vlicense) {
            global $db;

            $queryString = "SELECT * FROM vehicles WHERE vlicense = '$vlicense'";
            $result = $db->executePlainSQL($queryString);

            if (($vehicle = oci_fetch_array($result))) {
                return $vehicle; 
            } else {
                return false;
            }
        }

        function getDateDifference($idate, $fdate) {
            global $db, $date_format;

            $queryString = "SELECT to_date($fdate, '$date_format') - to_date($idate, '$date_format') AS datediff FROM dual";
            $result = $db->executePlainSQL($queryString);
            $row = oci_fetch_array($result);

            return (int)($row['DATEDIFF'] * 24);
        }
    ?>
</body>
</html>