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
        username VARCHAR(255) NOT NULL,
        useremail VARCHAR(255) NOT NULL,
        userpassword VARCHAR(255) NOT NULL
    )";

    // Execute query to create user_account table
    if ($con->query($createUserAccountTable) === TRUE) {
        echo "Table 'user_account' created successfully.<br>";

        // Insert initial values into user_account table
        $insertUserAccountValues = "INSERT INTO user_account (user_id, username, useremail, userpassword) 
                                    VALUES ('user1', 'John Doe', 'john@example.com', 'password1'),
                                           ('user2', 'Jane Smith', 'jane@example.com', 'password2')";
        if ($con->query($insertUserAccountValues) === TRUE) {
            echo "Initial values inserted into 'user_account' table successfully.<br>";
        } else {
            echo "Error inserting initial values into 'user_account' table: " . $con->error . "<br>";
        }
    } else {
        echo "Error creating table 'user_account': " . $con->error . "<br>";
    }

    // SQL query to create main_category table
    $createMainCategoryTable = "CREATE TABLE IF NOT EXISTS main_category (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        category VARCHAR(255) NOT NULL
    )";

    // Execute query to create main_category table
    if ($con->query($createMainCategoryTable) === TRUE) {
        echo "Table 'main_category' created successfully.<br>";

        // Insert initial values into main_category table
        $insertMainCategoryValues = "INSERT INTO main_category (category) 
                                     VALUES ('Category 1'),
                                            ('Category 2')";
        if ($con->query($insertMainCategoryValues) === TRUE) {
            echo "Initial values inserted into 'main_category' table successfully.<br>";
        } else {
            echo "Error inserting initial values into 'main_category' table: " . $con->error . "<br>";
        }
    } else {
        echo "Error creating table 'main_category': " . $con->error . "<br>";
    }

    // SQL query to create sub_category table
    $createSubCategoryTable = "CREATE TABLE IF NOT EXISTS sub_category (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        sub_category_name VARCHAR(255) NOT NULL,
        main_category_id INT(11),
        FOREIGN KEY (main_category_id) REFERENCES main_category(id)
    )";

    // Execute query to create sub_category table
    if ($con->query($createSubCategoryTable) === TRUE) {
        echo "Table 'sub_category' created successfully.<br>";

        // Insert initial values into sub_category table
        $insertSubCategoryValues = "INSERT INTO sub_category (sub_category_name, main_category_id) 
                                    VALUES ('Subcategory 1', 1),
                                           ('Subcategory 2', 1),
                                           ('Subcategory 3', 2)";
        if ($con->query($insertSubCategoryValues) === TRUE) {
            echo "Initial values inserted into 'sub_category' table successfully.<br>";
        } else {
            echo "Error inserting initial values into 'sub_category' table: " . $con->error . "<br>";
        }
    } else {
        echo "Error creating table 'sub_category': " . $con->error . "<br>";
    }
}

// Establish database connection
$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Define the name of the database
$dbName = 'your_database_name';

// Create the database if it doesn't exist
$createDbQuery = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($con->query($createDbQuery) === TRUE) {
    echo "Database $dbName created successfully.<br>";

    // Connect to the newly created database
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
    echo "Error creating database: " . $con->error . "<br>";
}

// Close connection
$con->close();
?>