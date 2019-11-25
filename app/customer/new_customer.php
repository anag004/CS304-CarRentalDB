<html>
<head>
    <title>Create New Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
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
                        Create New Account 
                        <div class="float-right btn btn-info btn-sm" onclick="window.location.href='../home.php';">
                            Home
                        </div>
                    </h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label> Name: </label>
                            <input type='text' name='NAME' class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <label>Address: </label>
                            <input type='text' name='ADDRESS' class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <label>Cellphone Number: </label>
                            <input type="tel" name="CELLPHONE" pattern="[0-9]*" class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <label>Driver's Licence Number:</label> 
                            <input type='tel' name="DLICENSE" class="form-control" required="true">
                        </div>
                        <div class="form-group">                        
                            <input type='submit' value="Create New Account" class = "btn btn-info btn-sm">
                            <input type='reset' value="Reset" class = "btn btn-info btn-sm">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                     
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <?php
        // Check if data has been POSTed
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Registers a new customer
            require "../Database.php";
            require "../ProjectUtils.php";

            $db = new Database();
            $db->connect();

            // Assemble the SQL query
            $queryString = "INSERT INTO CUSTOMERS VALUES(";
            $queryString .= $_POST['CELLPHONE'] . ", ";
            $queryString .= "'" . $_POST['NAME'] . "', ";
            $queryString .= "'" . $_POST['ADDRESS'] . "', ";
            $queryString .= $_POST['DLICENSE'] . ")";

            // Insert into the database and commit
            $db->executePlainSQL($queryString);
            $db->commit();

            // Redirect to success page
            header("Location: make_reservations.php?STATUS=registered&DLICENSE=".$_POST['DLICENSE']);
        }
    ?>
</body>
</html> 