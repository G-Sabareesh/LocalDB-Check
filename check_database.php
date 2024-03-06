<?php
// Define database connection parameters
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// Establish database connection
$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the database name is submitted via POST
if (isset($_POST['database_name'])) {
    // Get the submitted database name
    $dbName = $_POST['database_name'];

    // Check if the database exists
    $checkDbQuery = "SELECT SCHEMA_NAME 
                     FROM information_schema.SCHEMATA 
                     WHERE SCHEMA_NAME = '$dbName'";
    $result = $con->query($checkDbQuery);

    if ($result->num_rows > 0) {
        // Database exists
        echo "Database $dbName exists.<br>";

        // Connect to the existing database
        $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, $dbName);

        // Check connection to the existing database
        if ($con->connect_error) {
            die("Connection to $dbName failed: " . $con->connect_error);
        } else {
            echo "Connected to database $dbName.<br>";

            // Get a list of all tables in the database
            $showTablesQuery = "SHOW TABLES";
            $tableResult = $con->query($showTablesQuery);

            if ($tableResult->num_rows > 0) {
                echo "Tables in $dbName database:<br>";
                while ($row = $tableResult->fetch_row()) {
                    echo $row[0] . "<br>";
                }
            } else {
                echo "No tables found in $dbName database.<br>";
            }
        }
    } else {
        // Database does not exist
        echo "Database $dbName does not exist.<br>";

        // Include the setup_table.php file and pass the database name
        include 'setup_table.php';
    }
} else {
    // Database name not provided via POST
    echo "Please provide a database name.";
}

// Close connection
$con->close();
?>
