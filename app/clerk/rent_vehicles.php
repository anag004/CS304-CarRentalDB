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
    <script>
        $(document).ready(function(){
            function hide_inputs(x){
                console.log("asd");
                $(x).attr('value', '');
                // $(x).hide();
            }
            function set_res(){
                $(".res").show();
                $(".res").find("input").attr('required',true);
                $(".no-res").find("input").val('');
                $(".no-res").hide();
                $(".no-res").find("input").attr('required',false);
            }
            function set_no_res(){
                $(".no-res").show();
                $(".no-res").find("input").attr('required',true);
                $(".res").find("input").val('');
                $(".res").hide();
                $(".res").find("input").attr('required',false);
            }

            set_res();
            $('.res-toggle').click(function(){
                set_res();
            });
            $('.no-res-toggle').click(function(){
                set_no_res();
            });
        });
    </script> 

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
        
                            $diffHours = 1;
                            $date_format = 'YYYY-MM-DD:HH24:MI';
                            $driverExists = true;

                            // Code for renting a vehicle   
                            // Check if a POST request is sent 
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                // Declare necessary variables
                                $reservation = false;
                                $confNo = null;
                                $datetime_format = "'YYYY-MM-DD:HH:MI'";
                                $confNotUsed = true;

                                // Check if the confirmation number is given 
                                if (!isset($_POST['CONF_NO']) || $_POST['CONF_NO'] == "") {
   
                                    $idate = "'" . $_POST['FROM_DATE'] . ":" . $_POST['FROM_TIME'] . "'";
                                    $fdate = "'" . $_POST['TO_DATE'] . ":" . $_POST['TO_TIME'] . "'";
                                    $diffHours = getDateDifference($idate, $fdate);
                                    $driverExists = existCustomer();

                                    if ($diffHours >= 0) {
                                        if ($driverExists) {
                                            // Retrieve the reservation object and set variales
                                            // Look at the other data to make a reservation and link to the rental
                                            $confNo = ProjectUtils::makeReservation($_POST, $db);
                                            $reservation = ProjectUtils::getReservation($confNo, $db, "*");
                                        } else {
                                            echo ProjectUtils::getErrorBox("It seems you are not registered as a customer. <a href='../customer/new_customer.php?redirect_to=rent'>Register Here.</a>");
                                        } 
                                    } else {
                                        $reservation = false;
                                        echo ProjectUtils::getErrorBox("The initial date must be less than the final date.");
                                    }
                                } else {
                                    // Check if there is a previous rental with the same confirmation number
                                    $prevRental = getRental($_POST['CONF_NO']);

                                    if (!$prevRental) {
                                        // Find the reservation and set variables
                                        $reservation = ProjectUtils::getReservation($_POST['CONF_NO'], $db, "VTNAME, to_char(FROM_DATETIME, " . $datetime_format . ") AS FROM_DATETIME, to_char(TO_DATETIME, " . $datetime_format . ") AS TO_DATETIME, VTNAME, LOCATION");
                                        $confNo = $_POST['CONF_NO'];
                                    } else {
                                        $confNotUsed = false;
                                    }
                                }

                                if ($reservation && $confNotUsed) {
                                    // Check that the initial date < final date
                                    echo "DIFF $diffHours<br>";

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
                                    if (!$confNotUsed) {
                                        echo ProjectUtils::getErrorBox("This confirmation number has already been used.");
                                    } else  if ($diffHours >=0 && $driverExists) {
                                        echo ProjectUtils::getErrorBox("Invalid confirmation number");
                                    }
                                }
                            }
                            else{
                                if(isset($_GET['STATUS']) and isset($_GET['DLICENSE'])){
                                    echo ProjectUtils::getErrorBox("Account with license number ".$_GET['DLICENSE']." registered successfully.","blue");
                                }
                            }

                            // Checks if there exists some customer with the given dlicense
                            function existCustomer() {
                                global $db; 
                                $result = $db->executePlainSQL("SELECT COUNT(*) FROM customers WHERE dlicense = " . $_POST['DLICENSE']);
                                if (($row = oci_fetch_row($result)) != false) {
                                    if ($row[0] == 0) {
                                        return false;
                                    } else {
                                        return true;
                                    }
                                } else {
                                    echo ProjectUtils::getErrorBox("DBError");
                                    return false;
                                }
                            }

                            function getRental($confNo) {
                                global $db;

                                $queryString = "SELECT * FROM rentals WHERE conf_no = $confNo";
                                $result = $db->executePlainSQL($queryString);
                                
                                if (($rental = oci_fetch_array($result)) != false) {
                                    return $rental;
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
                    <form method="post">
                        <input type = "hidden" name="FETCH_DATA" value="true">
                        <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                            <label class="btn btn-info active res-toggle">
                                <input type="radio" name="options" checked value="res"> Reserved
                            </label>
                            <label class="btn btn-info no-res-toggle">
                                <input type="radio" name="options" value="no-res"> Unreserved
                            </label>
                        </div>
                        <div class="form-group res">
                            <label>Confirmation Number</label>
                            <input type="text" name="CONF_NO" class="form-control">
                        </div>
                        <div class="form-group no-res">
                            <label>Car Type:</label> 
                            <?php 
                                $result = $db->executePlainSQL("SELECT * FROM vehicle_types");
                                echo ProjectUtils::getDropdownString($result,"VTNAME","form-control", false);
                            ?>
                        </div>
                        <div class="form-group no-res">
                            <label>Location:</label> 
                            
                            <?php 
                                $result = $db->executePlainSQL("SELECT DISTINCT location FROM vehicles"); //fix
                                echo ProjectUtils::getDropdownString($result,"LOCATION","form-control", false);
                            ?>
                        </div>
                        
                        <div class="form-group no-res">
                            <label>From:</label> 
                            
                            <input type='date' name="FROM_DATE" class="form-control" min="1980-01-01">
                            <input type='time' name="FROM_TIME" class="form-control">
                        </div>
                        <div class="form-group no-res">        
                            <label>To: </label>
                            
                            <input type='date' name="TO_DATE" class="form-control" min="1980-01-01">
                            <input type='time' name="TO_TIME" class="form-control">
                        </div>
                        <div class="form-group no-res">
                            <label>Driver's License Number:</label> 
                            <input type='tel' name="DLICENSE" pattern="[0-9]*" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Card Name:</label>
                            <input type="text" name="CARD_NAME" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Card Number:</label>
                            <input type="text" name="CARD_NO" pattern="[0-9]*" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Card Expiry Date:</label>
                            <input type='date' name="EXP_DATE" class="form-control" min="1980-01-01">
                        </div>
                        <input type='submit' value="Rent Vehicle" class="btn btn-info btn-sm">
                        <input type='button' onclick="window.location.href='./rent_vehicles.php'" value="Reset" class="btn btn-info btn-sm" required>
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