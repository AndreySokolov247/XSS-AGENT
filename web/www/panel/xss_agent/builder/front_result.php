<?php
include "../settings/settings.php";

function writeToLog($message) {
    error_log(date('Y-m-d H:i:s') . ": " . $message . "\n", 3, '../logs/front_result.log');
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST parameters
    $builder_id = $_POST['builder_id'] ?? null;

    // Log the received parameter
    writeToLog("Received parameter: builder_id=$builder_id");

    // Validate required parameter
    if ($builder_id) {
        // Query the database for the implant link with the given builder_id
        $stmt_select = $conn->prepare("SELECT implant FROM builder WHERE builder_id = ?");
        $stmt_select->bind_param("s", $builder_id);

        // Execute the statement
        $stmt_select->execute();
        $stmt_select->bind_result($implant);

        // Fetch the result
        $stmt_select->fetch();

        // Check if a result was found
        if (!empty($implant)) {
            // Return the implant link if found
            $response = ['status' => 'success', 'implant' => $implant];
            echo json_encode($response);
            writeToLog("Implant link found for builder_id=$builder_id");
        } else {
            // Return an empty response if not found
            echo json_encode(['status' => 'success', 'implant' => '']);
            writeToLog("Implant link not found for builder_id=$builder_id");
        }

        // Close the statement
        $stmt_select->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing required parameter: builder_id']);
        writeToLog("Missing required parameter: builder_id");
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    writeToLog("Invalid request method");
}

// Close the connection
$conn->close();
?>
