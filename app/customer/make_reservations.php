<html>
<head>
    <title>Make Reservations</title>
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
        <div class = "col-md-8 mt-5">
            <div class="card rounded shadow shadow-sm">
                <div class="card-header">
                <h3 class="mb-0">
                        Make Reservations 
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

                    $date_format = 'YYYY-MM-DD:HH24:MI';

                    // Check if the USER has made a POST request
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (existVehicles()) {
                            if (existCustomer()) {
                                $idate = "'" . $_POST['FROM_DATE'] . ":" . $_POST['FROM_TIME'] . "'";
                                $fdate = "'" . $_POST['TO_DATE'] . ":" . $_POST['TO_TIME'] . "'";

                                $diffHours = getDateDifference($idate, $fdate);

                                if ($diffHours < 0) {
                                    echo ProjectUtils::getErrorBox("The initial date must be less than the final date.");
                                } else {
                                    // Add the reservation into the database using a utils function
                                    $confNo = ProjectUtils::makeReservation($_POST, $db);

                                    // Redirect to the view_reservations page
                                    header("Location: view_reservation.php?CONF_NO=" . $confNo);
                                }
                            } else {
                                echo ProjectUtils::getErrorBox("It seems you are not registered as a customer. <a href='new_customer.php?redirect_to=reserve'>Register Here.</a>");
                            }
                        } else {
                            echo ProjectUtils::getErrorBox("No vehicles exist.");
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

                    // Returns true iff there exist some vehicles 
                    function existVehicles() {
                        
                        global $db;
                        $queryString = "SELECT COUNT(*) FROM vehicles v" . ProjectUtils::getVehicleQueryString($_POST, $db);
                        $result = $db->executePlainSQL($queryString);

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
                        <div class="form-group">
                            <label>Car Type:</label> 
                            <?php 
                                $result = $db->executePlainSQL("SELECT * FROM vehicle_types");
                                echo ProjectUtils::getDropdownString($result,"VTNAME","form-control", false);
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Location:</label> 
                            
                            <?php 
                                $result = $db->executePlainSQL("SELECT DISTINCT location FROM vehicles"); //fix
                                echo ProjectUtils::getDropdownString($result,"LOCATION","form-control", false);
                            ?>
                        </div>
                        
                        <div class="form-group">
                            <label>From:</label> 
                            
                            <input type='date' name="FROM_DATE" class="form-control" required="true" value="01/18/1999" min="1980-01-01">
                            <input type='time' name="FROM_TIME" class="form-control" required="true" value="23:59">
                        </div>
                        <div class="form-group">        
                            <label>To: </label>
                            
                            <input type='date' name="TO_DATE" class="form-control" required="true" value="01/18/1999" min="1980-01-01">
                            <input type='time' name="TO_TIME" class="form-control" required="true" value="23:59">
                        </div>
                        <div class="form-group">
                            <label>Driver's License Number:</label> 
                            <input type='tel' name="DLICENSE" pattern="[0-9]*" class="form-control" required="true" default="1'">
                        </div>
                        <input type='submit' value="Make Reservation" class="btn btn-info btn-sm">
                        <input type='button' onclick="window.location.href='./make_reservations.php'" value="Reset" class="btn btn-info btn-sm">
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