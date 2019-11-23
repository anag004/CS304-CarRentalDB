<html>
<head><title>Return Vehicle</title></head>
<body>
<h3>Return Vehicle</h3>
<form method="post">
    Rental ID:
    <br>
    <input type="text" name="rid" pattern="[0-9]*">
    <br>
    <br>
    Return Time: 
    <br>
    <input type='date' name="date">
    <input type='time' name="time">
    <br>
    <br>
    Odometer: 
    <br>
    <input type='tel' name="odometer" pattern="[0-9]*">
    <br>
    <br>
    <input type='checkbox' name='tank' value='full'>    Tank Full  
    <br>
    <br>
    <input type='submit' value="Return Vehicle">
    <input type='reset' value="Reset">
    <hr>
</form> 
</body>
</html> 