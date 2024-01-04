<?php
// add_user.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['username']) || !isset($data['password']) || !isset($data['name']) || !isset($data['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid parameters']);
        exit();
    }

    $username = $data['username'];
    $password = $data['password'];
    $name = $data['name'];
    $email = $data['email'];

    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "industri";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "INSERT INTO user (username, password, name, email) VALUES ('$username', '$password', '$name', '$email')";
    
    if ($conn->query($sql) === TRUE) {
        $newUserId = $conn->insert_id;
        $response = ['userid' => $newUserId];

        echo json_encode($response);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error adding user']);
    }

    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request method']);
}
?>
