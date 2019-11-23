<html>
<head>
    <title>View Vehicles</title>
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
<body class="bg-info" style="font-family: 'Roboto Slab', serif;">
    <div class = "row h-100">
        <div class="col-md-2"></div>
        <div class = "col-md-8 mt-5">
            <div class="card rounded shadow shadow-sm">
                <div class="card-header">
                    <h3 class="mb-0">View Vehicles</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type = "hidden" name="FETCH_DATA" value="true">
                        <div class="form-group">
                            <label>Car Type:</label> 
                            <?php 
                                require "../Database.php";
                                require "../ProjectUtils.php";
                                $db = new Database();
                                $db->connect();
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
                            <input type='tel' name="dlicense" pattern="[0-9]*" class="form-control">
                        </div>
                        <input type='submit' value="Search" class="btn btn-info">
                        <input type='button' onclick="window.location.href='./make_reservations.php'" value="Reset" class="btn btn-info">
                    </form> 
                </div>
                <div class="card-footer">
                    Hello
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</form> 
</body>
</html> 