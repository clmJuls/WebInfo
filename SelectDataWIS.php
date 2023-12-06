<?php
$servername = "localhost";
$username = "clmJuls";
$password = "wis123";
$dbname = "studentinfo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Users</h2>";
    echo "<table border='1'><tr><th>ID</th><th>Username</th><th>Email</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["username"] . "</td><td>" . $row["email"] . "</td></tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
