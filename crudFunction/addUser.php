<?php 
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

// Create connection using mysqli (your current method)
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

try {
    // Get the posted data
    $data = json_decode(file_get_contents("php://input"));

    // Validate the required fields
    if (
        !empty($data->username) &&
        !empty($data->password) &&
        !empty($data->staffName) &&
        !empty($data->serviceName) &&
        !empty($data->userlevel)
    ) {
        // Check if username already exists
        $check_query = "SELECT COUNT(*) as count FROM user WHERE username = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("s", $data->username);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            http_response_code(400);
            echo json_encode(array("success" => false, "message" => "Username already exists."));
            exit();
        }

        // Get the next user ID (ascending order)
        $id_query = "SELECT MAX(user_id) AS max_id FROM user";
        $id_result = $conn->query($id_query);
        $id_row = $id_result->fetch_assoc();
        $next_user_id = $id_row['max_id'] + 1;  // Automatically increments the user ID

        // Skip password hashing: Store plain password
        $plain_password = $data->password;

        // Prepare the insert query
        $query = "INSERT INTO user (user_id, username, password, staffName, serviceName, userlevel) 
                 VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);

        // Bind the values
        $stmt->bind_param("isssss", $next_user_id, $data->username, $plain_password, $data->staffName, $data->serviceName, $data->userlevel);

        // Execute the query
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(array("success" => true, "message" => "User registered successfully."));
        } else {
            http_response_code(503);
            echo json_encode(array("success" => false, "message" => "Unable to register user."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("success" => false, "message" => "Unable to register user. Data is incomplete."));
    }
} finally {
    // Close the database connection
    $conn->close();
}
?>
