<?php
include "../../settings/settings.php";

function writeToLog($message) {
    error_log(date('Y-m-d H:i:s') . ": " . $message . "\n", 3, '../../logs/get_results.log');
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Retrieve POST parameters
    $bot_id = $_POST['bot_id'] ?? null;

    // Log the received parameters
    writeToLog("Received parameters: bot_id=$bot_id");

    // Validate parameters
    if ($bot_id) {
        // Prepare the SQL statement to retrieve the cmd_sent and cmd_received for the specified bot_id
        $stmt_select = $conn->prepare("SELECT cmd_sent, cmd_received FROM bots WHERE id = ?");
        $stmt_select->bind_param("i", $bot_id);

        // Execute the select statement
        if ($stmt_select->execute()) {
            $result = $stmt_select->get_result();
            if ($row = $result->fetch_assoc()) {
                $response = [
                    'status' => 'success',
                    'data' => [
                        'cmd_sent' => $row['cmd_sent'],
                        'cmd_received' => $row['cmd_received']
                    ]
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Bot not found.'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to retrieve data from the database.'
            ];
        }

        // Close the select statement
        $stmt_select->close();
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