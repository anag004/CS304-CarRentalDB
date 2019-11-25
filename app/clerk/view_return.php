<html>
<head>
    <title>Successful Return</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../modal.css">

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
        <div class = "col-md-8 my-auto">
            <div class="card rounded shadow shadow-sm">
                <div class="card-header">
                <h3 class="mb-0">
                        Successful Return! 
                        <div class="float-right btn btn-info btn-sm" onclick="window.location.href='../home.php';">
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

                    $vtype = getVehicleType($_GET['VTYPE']);
                    $diffHours = $_GET['DIFF'];
                    $distance = $_GET['DISTANCE'];

                    // Do the cost calculation =====
                    $rentalCost = 0; 

                    // Rental charges

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


                    $krate = $vtype['KRATE'];
                    $kCost = $krate * $distance;

                    $totalCost = $rentalCost + $insuranceCost + $kCost;
                    
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
                    echo "<strong>Rental Charges</strong><br>";
                    echo "Weekly Charges: $numWeeks x $wrate = $weeklyCost<br>";
                    echo "Daily Charges: $numDays x $drate = $dailyCost<br>";
                    echo "Hourly Charges: $numHours x $hrate = $hourlyCost<br>";
                    echo "Total rental cost: $rentalCost<br>";

                    echo "<br>";

                    echo "<strong>Insurance Charges</strong><br>";
                    echo "Weekly Charges: $numWeeks x $wirate = $weeklyCost<br>";
                    echo "Daily Charges: $numDays x $dirate = $dailyCost<br>";
                    echo "Hourly Charges: $numHours x $hirate = $hourlyCost<br>";
                    echo "Total insurance cost: $insuranceCost<br>";

                    echo "<br>";

                    echo "<strong>Kilometer Charges</strong><br>";
                    echo "Distance charges $$krate x $distance = $kCost<br>";

                    echo "<br>";

                    echo "<strong>Grand Total</strong> = $totalCost<br>";

                ?>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
       
    </body>
</html>