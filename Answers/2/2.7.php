<?php
/*Question #2.7

This question requires tight adherence to the defined spec.

The following code has many errors, problems and examples of bad usage of code.
Using only PHP functions or classes and methods (No vendor frameworks), rewrite the code so it is secure, efficient/optimised and returns no errors.

The purpose of the code is to connect to the database, and output data only from the column 'example_column' for however many rows that are returned.
The database query needs to be filtered to equal a querystring parameter called 'parameter' and to not equal the defined $example_integer.

// Connect to the database.
mysql_connect("localhost", 'admin', "password") or die(mysql_error());
mysql_select_db("my_database") or die(mysql_error());
// Set an INTEGER variable to be used within the database query.
$example_integer = "123"
// Retrieve ONLY the column 'example_column' from 'example_table'.
$result = mysql_query('SELECT * FROM example_table WHERE "example_column" == $_REQUEST['parameter'] && "example_column" NOT IN ("$example_integer")') or die(mysql_error());
// Loop through the returned record(s) from the database query and output all data for each row.
for ($i=0;($row=mysql_fetch_array($result));$i+1){ 
  print_r('<pre>'.$row);
} */

$servername = "localhost";
$username = "admin";
$password = "password";
$dbname = "my_database";

$example_integer = "123";
$parameter = $_REQUEST['parameter'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = 'SELECT example_column FROM example_table '.
'WHERE ('.
"example_column == '".mysql_real_escape_string($_REQUEST['parameter']). "'" . 
" AND example_column != $example_integer"
.')';


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> Example column: " . $row["example_column"]. "<br>";
    }
} else {
    echo "No results found";
}

$conn->close();