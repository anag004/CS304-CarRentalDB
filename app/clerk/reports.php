<html>
<head>
    <title>View Reports</title>
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
                        View Reports 
                        <div class="float-right btn btn-info btn-sm" onclick="window.location.href='../home.php';">
                            Home
                        </div>
                    </h3>
                </div>
                <div class="card-body">
                    <form method="get">
                        <input type = "hidden" name="FETCH_DATA" value="true">
                        <div class="form-group">
                            <label>Report Type:</label>
                            <select name="report_type" class="form-control">
                                <option value="total_rentals">Total Rentals</option>
                                <option value="branch_rentals">Branch Rentals</option>
                                <option value="total_returns">Total Returns</option>
                                <option value="branch_returns">Branch Returns</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Branch:</label> 
                            
                            <?php 
                                require "../Database.php";
                                require "../ProjectUtils.php";
                                $db = new Database();
                                $db->connect();
                                $result = $db->executePlainSQL("SELECT DISTINCT location FROM vehicles"); //fix
                                echo ProjectUtils::getDropdownString($result,"LOCATION","form-control");
                            ?>
                        </div>
                        
                        <div class="form-group">
                            <label>Date:</label> 
                            
                            <input type='date' name="date" class="form-control">
                        </div>
                        <input type='submit' value="Generate Report" class="btn btn-info btn-sm">
                        <input type='button' onclick="window.location.href='./reports.php'" value="Reset" class="btn btn-info btn-sm">
                    </form> 
                </div>
                <div class="card-footer">
                     
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <?php
        // Check if data needs to be fetched
        if ($_GET['FETCH_DATA'] == true) {
            // Check the kind of report to be generated
            if ($_GET['report_type'] == 'total_rentals') {
                // Report for all branches grouped by vehicle category and branch

                // Get the two dates set up
                $date_format = "'YYYY-MM-DD:HH:MIam'";
                $start_date = "'" . $_GET['date'] . ":12:00AM'";
                $end_date = "'" . $_GET['date'] . ":11:59PM'";

                // Assemble the SQL query
                $queryString = "SELECT v.location, v.vtname, v.make, v.model, v.year, v.color, v.vlicense FROM vehicles v, rentals rent, reservations res ";
                $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.conf_no = res.conf_no ";
                $queryString .= " AND to_date($start_date, $date_format) <= res.from_datetime ";
                $queryString .= " AND to_date($end_date, $date_format) >= res.from_datetime ";
                $queryString .= " ORDER BY v.location, v.vtname";

                // Query the database
                $result = $db->executePlainSQL($queryString);
                
                // Print the result in a table
                $tableHeader = array("LOCATION", "VTNAME", "MAKE", "MODEL", "YEAR", "COLOR", "VLICENSE");
                echo ProjectUtils::getResultInTable($result, $tableHeader)[1];
            } else if ($_GET['report_type'] == 'branch_rentals') {
                // Get the two dates set up
                $date_format = "'YYYY-MM-DD:HH:MIam'";
                $start_date = "'" . $_GET['date'] . ":12:00AM'";
                $end_date = "'" . $_GET['date'] . ":11:59PM'";

                // Assemble the SQL query
                $queryString = "SELECT v.vtname, v.make, v.model, v.year, v.color, v.vlicense FROM vehicles v, rentals rent, reservations res ";
                $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.conf_no = res.conf_no ";
                $queryString .= " AND to_date($start_date, $date_format) <= res.from_datetime ";
                $queryString .= " AND to_date($end_date, $date_format) >= res.from_datetime ";
                $queryString .= " ORDER BY v.vtname";

                // Query the database
                $result = $db->executePlainSQL($queryString);
                
                // Print the result in a table
                $tableHeader = array("VTNAME", "MAKE", "MODEL", "YEAR", "COLOR", "VLICENSE");
                echo ProjectUtils::getResultInTable($result, $tableHeader)[1];
            } else if ($_GET['report_type'] == 'total_returns') {

            } else if ($_GET['report_type'] == 'branch_returns') {

            }
        }
    ?>
</body>
</html> 