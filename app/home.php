<html>
<head>
    <title>Home</title>
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
        <div class="col-2"></div>
        <div class = "col-8 my-auto">
            <div class="card rounded shadow shadow-sm">
                <div class="card-header">
                <h3 class="mb-0">
                        Home 
                    </h3>
                </div>
                <div class="card-body">
                    <form>
                      <div class="form-group">
                            <label>Customer Actions:</label> 
                            <input type="button" onclick="window.location.href='customer/view_vehicles.php';" class="btn btn-info form-control mb-1" value="View Vehicles">
                            <input type="button" onclick="window.location.href='customer/make_reservations.php';" class="btn btn-info form-control mb-1" value="Make Reservations">

                        </div>
                        <div class="form-group">
                            <label>Clerk Actions:</label> 
                            <input type="button" onclick="window.location.href='clerk/rent_vehicles.php';" class="btn btn-info form-control mb-1" value="Rent Vehicles">
                            <input type="button" onclick="window.location.href='clerk/return_vehicles.php';" class="btn btn-info form-control mb-1" value="Return Vehicles">
                            <input type="button" onclick="window.location.href='clerk/reports.php';" class="btn btn-info form-control mb-1" value="Reports">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    Hello
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</body>
</html> 