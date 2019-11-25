<html>
<head>
    <title>View Vehicles</title>
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
                        View Vehicles 
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
                    $queryString=false;
                    $out=array('','');
                    $showButton=false;
                    if ($_GET['FETCH_DATA'] == "true") {
                        $whereString = ProjectUtils::getVehicleQueryString($_GET, $db);
                        $queryString = "SELECT * FROM vehicles v" . $whereString;
                        if ($whereString) {
                            $showButton=true;
                            $result = $db->executePlainSQL($queryString);
                            $out = ProjectUtils::getResultInTable($result, array('VLICENSE', 'MAKE', 'YEAR', 'COLOR', 'ODOMETER', 'VTNAME', 'LOCATION', 'CITY'));
                        }
                    }
                ?>
                    <form method="get">
                        <input type = "hidden" name="FETCH_DATA" value="true">
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
                            
                            <input type='date' name="FROM_DATE" class="form-control" min="1980-01-01">
                            <input type='time' name="FROM_TIME" class="form-control">
                        </div>
                        <div class="form-group">        
                            <label>To: </label>
                            
                            <input type='date' name="TO_DATE" class="form-control" min="1980-01-01">
                            <input type='time' name="TO_TIME" class="form-control">
                        </div>
                        
                        <input type='submit' value="Search" class="btn btn-info btn-sm">
                        <input type='button' onclick="window.location.href='./view_vehicles.php'" value="Reset" class="btn btn-info btn-sm">
                    </form> 
                </div>
                <div class="card-footer">
                <?php
                    if($showButton){
                        echo '<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">
                        Show Results
                    </button><span class="pl-3">'.$out[0].' vehicle(s) found</span>';
                    }
                ?>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

<?php 
    if ($queryString){
        echo "
            <div class='modal' id='myModal'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title'><strong>Available Vehicles</strong></h4>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                </div>
                <div class='modal-body'>";
        echo  $out[1];
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