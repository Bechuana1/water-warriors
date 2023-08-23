<?php
require_once './config.php';



$apiKey = 'b181edd4174f75f42827bfab7ce03188';
$partnerID = '8034';

// Set the API endpoint URL
$apiURL = "https://sms.textsms.co.ke/api/services/sendsms/";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// Get middle names from the database
$middlenames = array(); // Initialize an array to hold middlenames

// SQL query to retrieve all middlenames
$sql = "SELECT middlename FROM users";

// Execute the query
$result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        // Fetch the middlenames and store them in the array
        while ($row = $result->fetch_assoc()) {
            $middlenames[] = $row['middlename'];
        }
    } else {
        echo "Error: " . $conn->error;
    }

// Close the database connection
$conn->close();

// Initialize cURL session
$ch = curl_init();

foreach ($middlenames as $middlename) {
    // Prepare the request data
    $requestData = [
        'apikey' => $apiKey,
        'partnerID' => $partnerID,
        'message' => 'A new post has been made, dont miss. Regards, Dev. Water Warriors',
        'shortcode' => 'TextSMS',
        'mobile' => $middlename, 
    ];

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $apiURL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Execute cURL session and get the response
    $response = curl_exec($ch);

    // Decode and print the response
    $responseArray = json_decode($response, true);
    print_r($responseArray);
}

// Close cURL session
curl_close($ch);


}

?>

