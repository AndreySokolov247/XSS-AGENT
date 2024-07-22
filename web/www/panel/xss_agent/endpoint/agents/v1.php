<?php
include "../../settings/settings.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Query the database for the oldest bot with inspected set to 0, ordered by id
    $stmt_select = $conn->prepare("SELECT id, name, ip_address, process_name FROM bots WHERE inspected = 0 ORDER BY id ASC LIMIT 1");
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    // Prepare the response
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Prepare response with data
        $response = [
            'status' => 'success',
            'data' => [
                'id' => $row['id'],
                'name' => $row['name'],
                'ip_address' => $row['ip_address'],
                'process_name' => $row['process_name']
            ]
        ];
    } else {
        // No bot found
        $response = [
            'status' => 'error',
            'message' => 'No bot found with inspected status set to 0'
        ];
    }

    // Close the statement
    $stmt_select->close();
} else {
    // Handle non-POST requests
    $response = [
        'status' => 'error',
        'message' => 'Invalid request method. Please use POST.'
    ];
}

// Return the result as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
