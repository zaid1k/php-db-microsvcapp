<!DOCTYPE html>
<html>
<head>
<title>Docker Sample App</title>
</head>
<body>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $servername = "mysql"; // Assuming you're using a MySQL container named 'mysql'
    $username = "root";
    $password = "password";
    $dbname = "mydatabase";
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    
    // Create Connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO emp (name, phone) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $phone);
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close connection
    $stmt->close();
    $conn->close();
}
?>
<form action="index.php" method="POST">
    <input type="text" name="name">
    <input type="text" name="phone">
    <input type="submit" name="submit">
</form>
</body>
</html>