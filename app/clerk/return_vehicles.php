<html>
<head>
    <title>Return Vehicles</title>
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
                        Return Vehicles 
                        <div class="float-right btn btn-info btn-sm" onclick="window.location.href='../home.php';">
                            Home
                        </div>
                    </h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type = "hidden" name="FETCH_DATA" value="true">
                        <div class="form-group">
                            <label>Rental ID:</label>
                            <input type="text" name="rid" pattern="[0-9]*" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Return Time:</label> 
                                <input type='date' name="date" class="form-control">
                                <input type='time' name="time" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Odometer:</label> 
                            <input type='text' name="odometer" pattern="[0-9]*" class="form-control">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="tank" value="full">
                            <label class="form-check-label">Fuel Tank Full</label>
                        </div>
                        <br>
                        <input type='submit' value="Return Vehicle" class="btn btn-info btn-sm">
                        <input type='button' onclick="window.location.href='./return_vehicles.php'" value="Reset" class="btn btn-info btn-sm">
                    </form> 
                </div>
                <div class="card-footer">
                     
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</body>