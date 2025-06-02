<?php

global $dbUser, $dbPass, $instanceHost, $twilioAccountSid, $twilioAuthToken, $conn;

function getCustomMetadata($key) {
    $url = "http://metadata.google.internal/computeMetadata/v1/project/attributes/$key";
    $headers = ['Metadata-Flavor: Google'];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $httpCode === 200 ? $response : null;
}

// Get DB credentials from metadata
$dbUser = getCustomMetadata('DB_USER');
$dbPass = getCustomMetadata('DB_PASS');
$instanceHost = getCustomMetadata('INSTANCE_HOST');
$twilioAccountSid = getCustomMetadata('TWILIO_ACCOUNT');
$twilioAuthToken = getCustomMetadata('TWILIO_TOKEN');

// Create the connection and expose it globally
$conn = @mysqli_connect($instanceHost, $dbUser, $dbPass, "notas");

// Error logging (instead of fatal crash)
if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error());
    $conn = null;
}
function DBCreation(){

    global $dbUser, $dbPass, $instanceHost;

    $conn = mysqli_connect ( $instanceHost, $dbUser, $dbPass);

    $sql = ("drop database if exists notas");
    $conn->query($sql);

    $sql = ("create database if not exists notas");
    $conn->query($sql);

    $sql = ("use notas");
    $conn->query($sql);

    $sql = file_get_contents('notas.sql');
    $conn->multi_query($sql);

}

?>