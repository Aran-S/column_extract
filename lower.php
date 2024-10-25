<?php
$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "db_name"; /* Database name */
global $con;
$con = mysqli_connect($host, $user, $password,$dbname);
if (!$con) 
{
  die("Connection failed: " . mysqli_connect_error());
}

$result = $con->query("SHOW COLUMNS FROM table_name");
$columns = [];
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}

$updateQueries = [];
foreach ($columns as $column) {
    $updateQueries[] = "`$column` = LOWER(`$column`)";
}
$updateSQL = "UPDATE table_name SET " . implode(", ", $updateQueries);

if ($con->query($updateSQL) === TRUE) {
    echo "All text converted to lowercase successfully!";
} else {
    echo "Error: " . $con->error;
}

$con->close();
?>
fghygfuhf