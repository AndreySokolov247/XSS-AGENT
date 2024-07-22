<?php
include "../settings/settings.php";

// Query the database for the oldest builder based on ID where to_build is not 0
$stmt_select = $conn->prepare("SELECT * FROM builder WHERE to_build <> 0 ORDER BY id ASC LIMIT 1");
$stmt_select->execute();
$result = $stmt_select->get_result();

// Check if any row was found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Prepare response
    $response = [
        'status' => 'success',
        'data' => $row
    ];
} else {
    // No builder found
    $response = [
        'status' => 'error',
        'message' => 'builder not found'
    ];
}

// Close the statement
$stmt_select->close();

// Return the result as JSON
header('Content-Type: application/json');
echo json_encode($response);

?>