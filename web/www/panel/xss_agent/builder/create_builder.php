<?php
include "../settings/settings.php";

function writeToLog($message) {
    error_log(date('Y-m-d H:i:s') . ": " . $message . "\n", 3, '../logs/create_builder.log');
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST parameters
    $endpoint_url = $_POST['endpoint_url'] ?? null;
    $arc = $_POST['arc'] ?? null;
    $builder_id = $_POST['builder_id'] ?? null; 

    // Log the received parameters
    writeToLog("Received parameters: endpoint_url=$endpoint_url, arc=$arc, builder_id=$builder_id");

    // Validate required parameters
    if ($endpoint_url && $arc && $builder_id) {
        // Insert into the database table 'builder'
        $stmt_insert = $conn->prepare("INSERT INTO builder (builder_id, endpoint_url, arc) VALUES (?, ?, ?)");
        $stmt_insert->bind_param("sss", $builder_id, $endpoint_url, $arc);

        // Execute the statement
        if ($stmt_insert->execute()) {
            $response = ['status' => 'success', 'message' => 'Data inserted successfully'];

            echo json_encode($response);
            writeToLog($response['message']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data']);
            writeToLog("Failed to insert data");
        }

        // Close the insert statement
        $stmt_insert->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
        writeToLog("Missing required parameters");
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    writeToLog("Invalid request method");
}

// Close the connection
$conn->close();
?>
