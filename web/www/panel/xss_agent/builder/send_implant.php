<?php
include "../settings/settings.php";

function writeToLog($message) {
    error_log(date('Y-m-d H:i:s') . ": " . $message . "\n", 3, '../logs/upload_implant.log');
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST parameters
    $builder_id = $_POST['builder_id'] ?? null;
    $zip_file = $_FILES['zip_file'] ?? null;

    // Log the received parameters
    writeToLog("Received parameters: builder_id=$builder_id, zip_file=" . $zip_file['name']);

    // Validate required parameters
    if ($builder_id && $zip_file) {
        // Save the uploaded ZIP file
        $upload_dir = './uploads/';
        $zip_file_path = $upload_dir . basename($zip_file['name']);
        if (move_uploaded_file($zip_file['tmp_name'], $zip_file_path)) {
            writeToLog("ZIP file uploaded successfully: $zip_file_path");

            // Update the 'implant' and 'to_build' columns in the 'builder' table
            $zip_file_path_in_builder = './builder/' . $zip_file_path;
            $stmt_update = $conn->prepare("UPDATE builder SET implant = ?, to_build = 0 WHERE builder_id = ?");
            $stmt_update->bind_param("ss", $zip_file_path_in_builder, $builder_id);

            if ($stmt_update->execute()) {
                $response = ['status' => 'success', 'message' => 'Implant uploaded and updated successfully'];
                echo json_encode($response);
                writeToLog($response['message']);
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to update the implant path and to_build status'];
                echo json_encode($response);
                writeToLog($response['message']);
            }

            $stmt_update->close();
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to upload the ZIP file'];
            echo json_encode($response);
            writeToLog($response['message']);
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Missing required parameters'];
        echo json_encode($response);
        writeToLog($response['message']);
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method'];
    echo json_encode($response);
    writeToLog($response['message']);
}

// Close the connection
$conn->close();
?>