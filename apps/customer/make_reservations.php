<html>
<head><title>Make Reservation</title></head>
<body>
<h3>Make Reservation</h3>
<form method="post">
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
    <select name="location">
        <option value="ghar">Ghar</option>
    </select>
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