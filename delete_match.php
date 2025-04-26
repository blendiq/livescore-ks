<?php
// Include your database connection
include('db.php'); // Assuming db_connection.php has your connection code

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete query
    $delete_sql = "DELETE FROM matches WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Redirect to the matches table or another page after deletion
    header("Location: dashboard.php");
    exit();
} else {
    die("No match ID specified for deletion.");
}
?>
