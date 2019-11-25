<html>
<head>
    <title>View Reports</title>
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

    <script>
        $(window).on('load',function(){
            $('#myModal').modal('show');
        });
        $(document).ready(function(){
            var table = $("table");
            if(table.length){
                var rows = $("tbody").children("tr");
                if(rows.length){
                    var color = "primaryColor1";
                    var prefix = "secondaryColor1";
                    var branch=rows.eq(0).children("td").eq(1).text();
                    var type=rows.eq(0).children("td").eq(2).text();
                    for(var i=0; i<rows.length;i++){
                        if(branch!=rows.eq(i).children("td").eq(1).text()){
                            if(color=="primaryColor1"){
                                color="primaryColor2";
                            }
                            else if(color=="primaryColor2"){
                                color="primaryColor1";
                            }
                            if(prefix=="secondaryColor2"){
                                prefix="secondaryColor1";
                            }
                            else if(prefix=="secondaryColor2"){
                                prefix="secondaryColor1";
                            }
                        }
                        else if(type!=rows.eq(i).children("td").eq(2).text()){
                            if(prefix=="secondaryColor2"){
                                prefix="secondaryColor1";
                            }
                            else if(prefix=="secondaryColor1"){
                                prefix="secondaryColor2";
                            }
                        }
                        branch=rows.eq(i).children("td").eq(1).text();
                        type=rows.eq(i).children("td").eq(2).text();
                        rows.eq(i).addClass(prefix+" "+color);
                        // var bgclass=prefix+color;
                        // switch (prefix+color) {
                        //     case "lightgreen":
                                
                        //         break;
                        //     case "darkgreen":
                                
                        //         break;
                        //     case "lightblue":
                                
                        //         break;
                        //     case "lightblue":
                                
                        //         break;
                        
                        //     default:
                        //         break;
                        // }
                    }
                    // var type=
                    // var branch=
                }
            }
        });
    </script>
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
                            
                            <input type='date' name="date" class="form-control" required="true">
                        </div>
                        <input type='submit' value="Generate Report" class="btn btn-info btn-sm">
                        <input type='button' onclick="window.location.href='./reports.php'" value="Reset" class="btn btn-info btn-sm">
                    </form> 
                </div>
                <div class="card-footer">
                <?php
                    $out=false;
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
                            $out.= "<strong>Vehicles rented by type and branch</strong><br>";
                            $tableHeader = array("LOCATION", "VTNAME", "MAKE", "MODEL", "YEAR", "COLOR", "VLICENSE");
                            $tableData = ProjectUtils::getResultInTable($result, $tableHeader,"two-split");
                            $totalRentals = $tableData[0];
                            $out.= $tableData[1];

                            $out.= "<strong>$totalRentals new rental(s) for the whole company</strong><br>";

                            // Number of vehicles rented for each vehicle type

                            // Assemble the query
                            $queryString = "SELECT v.vtname, COUNT(*) AS COUNT FROM vehicles v, reservations res, rentals rent";
                            $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.conf_no = res.conf_no";
                            $queryString .= " AND to_date($start_date, $date_format) <= res.from_datetime ";
                            $queryString .= " AND to_date($end_date, $date_format) >= res.from_datetime ";
                            $queryString .= " GROUP BY v.vtname";

                            // Query the database
                            $result = $db->executePlainSQL($queryString);
                            
                            // Print the result in a table
                            $out.= "<strong>Number of vehicles of each type rented in all branches</strong><br>";
                            $tableHeader = array("VTNAME", "COUNT");
                            $out.= ProjectUtils::getResultInTable($result, $tableHeader)[1];

                            // Number of rentals at each branch
                            // Assemble the query
                            $queryString = "SELECT v.location, COUNT(*) AS COUNT FROM vehicles v, reservations res, rentals rent";
                            $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.conf_no = res.conf_no";
                            $queryString .= " AND to_date($start_date, $date_format) <= res.from_datetime ";
                            $queryString .= " AND to_date($end_date, $date_format) >= res.from_datetime ";
                            $queryString .= " GROUP BY v.location";

                            // Query the database
                            $result = $db->executePlainSQL($queryString);
                            
                            // Print the result in a table
                            $out.= "<strong>Number of vehicles of all types rented across each branch</strong><br>";
                            $tableHeader = array("LOCATION", "COUNT");
                            $out.= ProjectUtils::getResultInTable($result, $tableHeader)[1];
                        } else if ($_GET['report_type'] == 'branch_rentals') {
                            if ($_GET['LOCATION'] == 'all') {
                                echo ProjectUtils::getErrorBox("To view branch rentals you must select a branch");
                            } else {
                                // Get the two dates set up
                                $date_format = "'YYYY-MM-DD:HH:MIam'";
                                $start_date = "'" . $_GET['date'] . ":12:00AM'";
                                $end_date = "'" . $_GET['date'] . ":11:59PM'";
                                $location = $_GET['LOCATION'];

                                // Assemble the SQL query
                                $queryString = "SELECT v.vtname, v.make, v.model, v.year, v.color, v.vlicense FROM vehicles v, rentals rent, reservations res ";
                                $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.conf_no = res.conf_no ";
                                $queryString .= " AND v.location  = '$location'";
                                $queryString .= " AND to_date($start_date, $date_format) <= res.from_datetime ";
                                $queryString .= " AND to_date($end_date, $date_format) >= res.from_datetime ";
                                $queryString .= " ORDER BY v.vtname";

                                // Query the database
                                $result = $db->executePlainSQL($queryString);
                                
                                $out.= "<strong>Vehicles rented by type</strong>";
                                // Print the result in a table
                                $tableHeader = array("VTNAME", "MAKE", "MODEL", "YEAR", "COLOR", "VLICENSE");
                                $tableData = ProjectUtils::getResultInTable($result, $tableHeader,"one-split");
                                $out= $tableData[1];

                                $out.= "<strong>Total $tableData[0] new vehicles rented at this branch</strong>";

                                // Number of vehicles rented for each vehicle type

                                // Assemble the query
                                $queryString = "SELECT v.vtname, COUNT(*) AS COUNT FROM vehicles v, reservations res, rentals rent";
                                $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.conf_no = res.conf_no";
                                $queryString .= " AND v.location  = '$location'";
                                $queryString .= " AND to_date($start_date, $date_format) <= res.from_datetime ";
                                $queryString .= " AND to_date($end_date, $date_format) >= res.from_datetime ";
                                $queryString .= " GROUP BY v.vtname";

                                // Query the database
                                $result = $db->executePlainSQL($queryString);
                                
                                // Print the result in a table
                                $out.= "<strong>Number of vehicles of each type rented at this branch</strong><br>";
                                $tableHeader = array("VTNAME", "COUNT");
                                $out.= ProjectUtils::getResultInTable($result, $tableHeader)[1];          
                            }
                        } else if ($_GET['report_type'] == 'total_returns') {
                            $date_format = "'YYYY-MM-DD'";
                            $date_value = $_GET['date'];

                            // Assemble the SQL query
                            $queryString = "SELECT v.location, v.vtname, v.make, v.model, v.year, v.color, v.vlicense FROM vehicles v, rentals rent, returns ret ";
                            $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.rid = ret.rid ";
                            $queryString .= " AND to_date('$date_value', $date_format) = ret.return_date";
                            $queryString .= " ORDER BY v.location, v.vtname";

                            // Query the database
                            $result = $db->executePlainSQL($queryString);
                            
                            $out.= "<strong>Vehicles returned by type and branch</strong><br>";

                            // Print the result in a table
                            $tableHeader = array("LOCATION", "VTNAME", "MAKE", "MODEL", "YEAR", "COLOR", "VLICENSE");
                            $out.= ProjectUtils::getResultInTable($result, $tableHeader,"two-split")[1];

                            // ============= Number and revenue by category =================

                            // Assemble the SQL query
                            $queryString = "SELECT v.vtname, SUM(ret.value) AS revenue, COUNT(*) AS count FROM vehicles v, rentals rent, returns ret ";
                            $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.rid = ret.rid ";
                            $queryString .= " AND to_date('$date_value', $date_format) = ret.return_date";
                            $queryString .= " GROUP BY v.vtname";

                            // Query the database
                            $result = $db->executePlainSQL($queryString);
                            
                            // Print the result in a table
                            $tableHeader = array("VTNAME", "REVENUE", "COUNT");
                            $out.= "<strong>Revenue and number of vehicles returned for each vehicle type</strong>";
                            $out.= ProjectUtils::getResultInTable($result, $tableHeader)[1];

                            // ============= Number and revenue by branch =================
                            
                            // Assemble the SQL query
                            $queryString = "SELECT v.location, SUM(ret.value) AS revenue, COUNT(*) AS count FROM vehicles v, rentals rent, returns ret ";
                            $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.rid = ret.rid ";
                            $queryString .= " AND to_date('$date_value', $date_format) = ret.return_date";
                            $queryString .= " GROUP BY v.location";

                            // Query the database
                            $result = $db->executePlainSQL($queryString);
                            
                            // Print the result in a table
                            $tableHeader = array("LOCATION", "REVENUE", "COUNT");
                            $out.= "<strong>Revenue and number of vehicles returned for each branch</strong>";
                            $out.= ProjectUtils::getResultInTable($result, $tableHeader)[1];

                            // ============= Grand total for the day =======================
                            
                            // Assemble the SQL query
                            $queryString = "SELECT SUM(ret.value) FROM vehicles v, rentals rent, returns ret ";
                            $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.rid = ret.rid ";
                            $queryString .= " AND to_date('$date_value', $date_format) = ret.return_date";

                            // Query the database
                            $result = $db->executePlainSQL($queryString);
                            $total = oci_fetch_row($result)[0];
                            $out.= "<strong>Grand total for the day is $total CAD</strong><br>";

                        } else if ($_GET['report_type'] == 'branch_returns') {
                            if ($_GET['LOCATION'] == 'all') {
                                ProjectUtils::getErrorBox("To view branch returns you must select a branch.");
                            } else {
                                $date_format = "'YYYY-MM-DD'";
                                $date_value = $_GET['date'];
                                $location = $_GET['LOCATION'];

                                // Assemble the SQL query
                                $queryString = "SELECT v.vtname, v.make, v.model, v.year, v.color, v.vlicense FROM vehicles v, rentals rent, returns ret ";
                                $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.rid = ret.rid ";
                                $queryString .= " AND to_date('$date_value', $date_format) = ret.return_date";
                                $queryString .= " AND v.location = '$location'";
                                $queryString .= " ORDER BY v.vtname";

                                // Query the database
                                $result = $db->executePlainSQL($queryString);
                                
                                $out.= "<strong>Number of vehicles of each type returned in all branches</strong><br>";

                                // Print the result in a table
                                $tableHeader = array("VTNAME", "MAKE", "MODEL", "YEAR", "COLOR", "VLICENSE");
                                $out.= ProjectUtils::getResultInTable($result, $tableHeader, "two-split")[1];

                                // ============= Number and revenue by category =================

                                // Assemble the SQL query
                                $queryString = "SELECT v.vtname, SUM(ret.value) AS revenue, COUNT(*) AS count FROM vehicles v, rentals rent, returns ret ";
                                $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.rid = ret.rid ";
                                $queryString .= " AND to_date('$date_value', $date_format) = ret.return_date";
                                $queryString .= " AND v.location = '$location'";
                                $queryString .= " GROUP BY v.vtname";

                                // Query the database
                                $result = $db->executePlainSQL($queryString);
                                
                                // Print the result in a table
                                $tableHeader = array("VTNAME", "REVENUE", "COUNT");
                                $out.= "<strong>Revenue and number of vehicles returned for each vehicle type</strong>";
                                $out.= ProjectUtils::getResultInTable($result, $tableHeader)[1];

                                // ============= Grand total for the day =======================
                                
                                // Assemble the SQL query
                                $queryString = "SELECT SUM(ret.value) FROM vehicles v, rentals rent, returns ret ";
                                $queryString .= " WHERE rent.vlicense = v.vlicense AND rent.rid = ret.rid ";
                                $queryString .= " AND v.location = '$location'";
                                $queryString .= " AND to_date('$date_value', $date_format) = ret.return_date";

                                // Query the database
                                $result = $db->executePlainSQL($queryString);
                                $total = oci_fetch_row($result)[0];
                                $out.= "<strong>Grand total for the day is $total CAD</strong><br>";
                            }
                        }
                        echo '<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">
                                Show Results
                                </button><span class="pl-3">';
                    }
                ?>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <?php 
        if ($out!=false) {
            echo "
                <div class='modal' id='myModal'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                    <div class='modal-header'>
                        <h4 class='modal-title'><strong>Available Vehicles</strong></h4>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body'>";
            echo  $out;
            echo "</div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-info btn-sm' data-dismiss='modal'>Close</button>
                    </div>
                    </div>
                </div>
                </div>
            ";
        }
    ?>
</body>
</html> 