<html>
<head><title>Rent Vehicle</title></head>
<body>
<h3>Rent Vehicle</h3>
<form method="post">
    Confirmation Number:
    <br>
    <input type="text" name="conf_no" pattern="[0-9]*">
    <br>
    <br>
    Car Type: 
    <br>
    <select name="cartype">
        <option value="volvo">Volvo</option>
        <option value="saab">Saab</option>
        <option value="fiat">Fiat</option>
        <option value="audi">Audi</option> 
    </select>
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
    Card Name: 
    <br>
    <input type='text' name='card_name'>
    <br>
    <br>
    Card Number: 
    <br>
    <input type='tel' name="card_no" pattern="[0-9]*">
    <br>
    <br>
    Card Expiry Date: 
    <br>
    <input type='date' name="exp_date">
    <br>
    <br>
    <input type='submit' value="Rent Vehicle">
    <input type='reset' value="Reset">
    <hr>
</form> 
</body>
</html> 