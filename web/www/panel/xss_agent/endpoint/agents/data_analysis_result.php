<?php
include "../../settings/settings.php";

function writeToLog($message) {
    error_log(date('Y-m-d H:i:s') . ": " . $message . "\n", 3, '../../logs/get_results.log');
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Retrieve POST parameters
    $bot_name = $_POST['bot_name'] ?? null;
    $analysis_result = $_POST['analysis_result'] ?? null;
    $agent_name = $_POST['agent_name'] ?? null;

    // Log the received parameters
    writeToLog("Received parameters: bot_name=$bot_name, analysis_result=$analysis_result, agent_name=$agent_name");

    // Prepare to insert into logs table
    $stmt_log = $conn->prepare("INSERT INTO logs (agent, bot, content) VALUES (?, ?, ?)");
    $stmt_log->bind_param("sss", $agent_name, $bot_name, $analysis_result);

    // Execute the insert statement for logs
    if ($stmt_log->execute()) {
        $response = [
            'status' => 'success',
            'message' => 'Log entry created successfully.'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Failed to write log entry.'
        ];
    }
    $stmt_log->close();
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
