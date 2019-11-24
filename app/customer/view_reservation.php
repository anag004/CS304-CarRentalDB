<html>
<head>
    <title>Successful Reservation</title>
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
                        Successful Reservation! 
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

                    // Find a reservation object
                    $result = $db->executePlainSQL("SELECT * FROM reservations WHERE conf_no = '" . $_GET['CONF_NO'] . "'");

                    // Print this reservation object
                    if (($row = oci_fetch_row($result)) != false) {
                        echo "<table class='table'>";
                        $hlist=array("CONFIRMATION NUMBER","VEHICLE TYPE","DRIVER'S LICENSE NUMBER","BEGIN DATE/TIME","END DATE/TIME","LOCATION");
                        for($i=0; $i<6;$i++){
                            echo "<tr><td>".$hlist[$i]."</td><td>".$row[$i]."</td></tr>";
                        }
                    } else {
                        echo ProjectUtils::getErrorBox("Invalid reservation conf_no");
                    }
                ?>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
       
    </body>
</html>