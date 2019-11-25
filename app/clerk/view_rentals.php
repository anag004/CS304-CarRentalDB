<html>
<head>
    <title>Successful Rentalrn</title>
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
                        Successful Rental! 
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
                    
                    $rentalResult = $db->executePlainSQL("SELECT * FROM rentals WHERE rid = '" . $_GET['RID'] . "'");
            
                    // Find the corresponding reservation
                    $reservationResult = $db->executePlainSQL("SELECT * FROM reservations WHERE conf_no = '" . $_GET['CONF_NO'] . "'");

                    // Print this rental object
                    if (($rental = oci_fetch_array($rentalResult)) != false && ($reservation = oci_fetch_array($reservationResult)) != false) {
                        echo "<table class='table'>";
                        $hlist=array("RENTAL ID","VEHICLE LICENSE NUMBER","DRIVER'S LICENSE NUMBER","LOCATION");
                        $ilist=array("RID","VLICENSE","DLICENSE","LOCATION");
                        for($i=0; $i<2;$i++){
                            echo "<tr><td>".$hlist[$i]."</td><td>".$rental[$ilist[$i]]."</td></tr>";
                        }
                        for($i=2; $i<4;$i++){
                            echo "<tr><td>".$hlist[$i]."</td><td>".$reservation[$ilist[$i]]."</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo ProjectUtils::getErrorBox("Invalid rental ID");
                    }
                ?>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
       
    </body>
</html>
