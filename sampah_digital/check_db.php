<?php
include 'db_config.php';

// Check existing tables
$sql = "SHOW TABLES";
$result = $conn->query($sql);

echo "<h2>Existing Tables:</h2>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_array()) {
        echo "- " . $row[0] . "<br>";
    }
} else {
    echo "No tables found.<br>";
}

// Check sampah_digital table structure if it exists
$sql = "DESCRIBE sampah_digital";
$result = $conn->query($sql);

if ($result) {
    echo "<h2>sampah_digital Table Structure:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "sampah_digital table does not exist.<br>";
}

// Check users table structure if it exists
$sql = "DESCRIBE users";
$result = $conn->query($sql);

if ($result) {
    echo "<h2>users Table Structure:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "users table does not exist.<br>";
}

$conn->close();
?>
