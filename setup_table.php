<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Define database connection parameters
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// Function to create tables and insert initial values
function createTables($con, $dbName) {
    // SQL query to create user_account table
    $createUserAccountTable = "CREATE TABLE IF NOT EXISTS user_account (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id VARCHAR(255) UNIQUE NOT NULL,
        user_name VARCHAR(255) NOT NULL,
        user_email VARCHAR(255) NOT NULL,
        user_password VARCHAR(255) NOT NULL
    )";

    // Execute query to create user_account table
    if ($con->query($createUserAccountTable) === TRUE) {
        echo "Table 'user_account' created successfully.<br>";

        // Insert initial values into user_account table
        $insertUserAccountValues = "INSERT INTO user_account (user_id, user_name, user_email, user_password) 
                                    VALUES ('sabareesh@123', 'Sabareesh', 'sabareesh@gmail.com', 'sabareesh@123')";
        if ($con->query($insertUserAccountValues) === TRUE) {
            echo "Initial values inserted into 'user_account' table successfully.<br>";
        } else {
            echo "Error inserting initial values into 'user_account' table: " . $con->error . "<br>";
        }
    } else {
        echo "Error creating table 'user_account': " . $con->error . "<br>";
    }

    // SQL query to create def_category table
    $createMainCategoryTable = "CREATE TABLE IF NOT EXISTS def_category (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        def_cat_name VARCHAR(255) NOT NULL,
        user_id VARCHAR(255) NOT NULL
    )";

    // Execute query to create def_category table
    if ($con->query($createMainCategoryTable) === TRUE) {
        echo "Table 'def_category' created successfully.<br>";

        // Insert initial values into def_category table
        $insertMainCategoryValues = "INSERT INTO def_category (def_cat_name, user_id) 
                                     VALUES ('House Holding', '0'),
                                           ('Food', '0'),
                                           ('Grocery', '0'),
                                           ('Entertainment', '0'),
                                           ('Travel', '0'),
                                           ('Transport', '0'),
                                           ('Recharge', '0')";
        if ($con->query($insertMainCategoryValues) === TRUE) {
            echo "Initial values inserted into 'def_category' table successfully.<br>";
        } else {
            echo "Error inserting initial values into 'def_category' table: " . $con->error . "<br>";
        }
    } else {
        echo "Error creating table 'def_category': " . $con->error . "<br>";
    }

    // SQL query to create sub_category table
    $createSubCategoryTable = "CREATE TABLE IF NOT EXISTS sub_category (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        sub_cat_name VARCHAR(255) NOT NULL,
        def_category_id INT(11),
        user_id VARCHAR(255) NOT NULL,
        FOREIGN KEY (def_category_id) REFERENCES def_category(id)
    )";

    // Execute query to create sub_category table
    if ($con->query($createSubCategoryTable) === TRUE) {
        echo "Table 'sub_category' created successfully.<br>";
    } else {
        echo "Error creating table 'sub_category': " . $con->error . "<br>";
    }
}

// print_r($_GET);
echo "start";

// Establish database connection
$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


// Check if the database name is passed
if (isset($dbName)) {
    echo "HI".$dbName;
    // Connect to the provided database name
    $createDbQuery = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($con->query($createDbQuery) === TRUE) {
    echo "Database $dbName created successfully.";
    $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, $dbName);

    // Check connection to the new database
    if ($con->connect_error) {
        die("Connection to $dbName failed: " . $con->connect_error);
    } else {
        echo "Connected to database $dbName.<br>";

        // Call function to create tables
        createTables($con, $dbName);
    }
} else {
    echo "Error creating database: " . $con->error;
}
    
} else {
    echo "Database name not provided.";
}

// Close connection
$con->close();
?>
</body>
</html>
