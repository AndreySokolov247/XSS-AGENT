<?php

    // Turn off all error reporting
    //error_reporting(0);

    // Disable display of errors
    //ini_set('display_errors', 0);

    // Database settings
    $hostname = 'db';
    $username = 'xss_agent';
    $password = 'password';
    $database = 'xss_agent';

    // Connect to the database
    $conn = mysqli_init();
    mysqli_real_connect($conn, $hostname, $username, $password, $database);

?>