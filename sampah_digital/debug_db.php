<?php
include 'db_config.php';

echo "<h2>Database Debug Information</h2>";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<p>✅ Database connection successful</p>";

// Check if table exists
$result = $conn->query("SHOW TABLES LIKE 'sampah_digital'");
if ($result->num_rows > 0) {
    echo "<p>✅ Table 'sampah_digital' exists</p>";
} else {
    echo "<p>❌ Table 'sampah_digital' does not exist</p>";
}

// Show table structure
echo "<h3>Table Structure:</h3>";
$result = $conn->query("DESCRIBE sampah_digital");
if ($result) {
    echo "<table border='1'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $result->fetch_assoc()) {
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
    echo "<p>❌ Error getting table structure: " . $conn->error . "</p>";
}

$conn->close();
?>
