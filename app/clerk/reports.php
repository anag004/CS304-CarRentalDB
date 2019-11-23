<html>
<head><title>View Daily Reports</title></head>
<body>
<h3>View Vehicles</h3>
<form method="post">
<br>
    Report Type: 
    <br>
    <select name="report_type">
        <option value="total_rentals">Total Rentals</option>
        <option value="branch_rentals">Branch Rentals</option>
        <option value="total_reservations">Total Reservations</option>
        <option value="branch_reservations">Branch Reservations</option>
    </select>
    <br>
    <br>
    Branch: 
    <br>
    <select name="branch">
        <option value="ghar">Ghar</option>
    </select>
    <br>
    <br>
    Date: 
    <br>
    <input type='date' name="date">
    <br>
    <br>
    <input type='submit' value="Search">
    <input type='reset' value="Reset">
    <hr>
</form> 
</body>
</html> 