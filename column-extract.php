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
$result = $con->query("SELECT * FROM table_name LIMIT 1");
$firstRow = $result->fetch_assoc();

$columns = [];
foreach ($firstRow as $columnName => $value) {
    $columnName = preg_replace('/[^a-zA-Z0-9_]/', '_', $value);

    if (strlen($value) > 100) {
        $columns[] = "`$columnName` TEXT"; 
    } elseif (is_numeric($value) && strpos($value, '.') === false) {
        $columns[] = "`$columnName` INT"; 
    } elseif (is_numeric($value) && strpos($value, '.') !== false) {
        $columns[] = "`$columnName` DECIMAL(10, 2)"; 
    } else {
        $columns[] = "`$columnName` VARCHAR(100)"; 
    }
}

$createTableQuery = "CREATE TABLE table_name (" . implode(", ", $columns) . ");";

if ($con->query($createTableQuery) === TRUE) {
    echo "New table created successfully!";
} else {
    echo "Error creating table: " . $con->error;
}

$con->query("INSERT INTO table_name SELECT * FROM table_name LIMIT 1, 18446744073709551615");

 //$con->query("DROP TABLE student_list");

$con->close();
?>
