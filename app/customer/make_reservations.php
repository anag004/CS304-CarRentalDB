<html>
<head><title>Make Reservation</title></head>
<body>
<h3>Make Reservation</h3>
<form method="post">
<br>
    Car Type: 
    <br>
    <?php 
        require "../Database.php";
        require "../ProjectUtils.php";
        $db = new Database();
        $db->connect();
        $result = $db->executePlainSQL("SELECT * FROM vehicle_types");
        echo ProjectUtils::getDropdownString($result,"VTNAME");
    ?>
    <br>
    <br>
    Location: 
    <br>
    <?php 
        $result = $db->executePlainSQL("SELECT * FROM vehicle_types"); //fix
        echo ProjectUtils::getDropdownString($result,"VTNAME");
    ?>
    <br>
    <br>
    From: 
    <br>
    <input type='date' name="date1">
    <input type='time' name="time1">
    <br>
    <br>
    To: 
    <br>
    <input type='date' name="date2">
    <input type='time' name="time2">
    <br>
    <br>
    Driver's License Number: 
    <br>
    <input type='tel' name="dlicense" pattern="[0-9]*">
    <br>
    <br>
    <input type='submit' value="Make Reservation">
    <input type='reset' value="Reset">
    <hr>
</form> 
</body>
</html> 