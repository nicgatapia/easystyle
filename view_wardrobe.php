<!--This file contains the logic and structure of the view wardrobe page.-->
<!DOCTYPE html>
<html>
<head>
    <title>View Wardrobe</title>
    <style>
        /* Add your CSS styles here */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h1>View Wardrobe</h1>
<?php
require_once 'db_connection.php';

$conn = openConnect();

$sql = "SELECT * FROM view_wardrobe_table";

$result = queryDB($conn, $sql);

// Start of HTML table
echo "<table>";
echo "<tr><th>Item ID</th><th>Color</th><th>Attire</th><th>Type</th><th>Brand</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['IID'] . "</td>";
    echo "<td>" . $row['COLOR'] . "</td>";
    echo "<td>" . $row['ATTIRE'] . "</td>";
    echo "<td>" . $row['TYPE'] . "</td>";
    echo "<td>" . $row['BRAND'] . "</td>";
    echo "</tr>";
}

echo "</table>"; // End of HTML table

closeConnect($conn);
?>
</body>
</html>