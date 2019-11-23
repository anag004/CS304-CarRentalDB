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
                        <div class="float-right btn btn-info" onclick="window.location.href='../home.php';">
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
                                <option value="total_reservations">Total Reservations</option>
                                <option value="branch_reservations">Branch Reservations</option>
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
                        <input type='submit' value="Generate Report" class="btn btn-info">
                        <input type='button' onclick="window.location.href='./reports.php'" value="Reset" class="btn btn-info">
                    </form> 
                </div>
                <div class="card-footer">
                    Hello
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</body>
</html> 