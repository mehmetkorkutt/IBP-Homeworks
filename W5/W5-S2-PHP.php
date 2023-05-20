<?php
// MySQL database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "labapplication";

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize and validate input data
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validate and sanitize the form data
$full_name = validateInput($_POST['full-name']);
$email = validateInput($_POST['email']);
$gender = validateInput($_POST['gender']);

// Perform server-side form validation
$errors = array();
if (empty($full_name)) {
    $errors[] = "Full name is required.";
}

if (empty($email)) {
    $errors[] = "Email address is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email address.";
}

if (empty($gender)) {
    $errors[] = "Gender is required.";
}

// If there are any errors, display them on the web page
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
} else {
    // Data is valid, insert into the "students" table
    $sql = "INSERT INTO students (full_name, email, gender) VALUES ('$full_name', '$email', '$gender')";

    if ($conn->query($sql) === true) {
        echo "Student information inserted successfully.";
    } else {
        echo "Error inserting student information: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
