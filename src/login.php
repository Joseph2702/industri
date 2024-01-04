<?php
// login.php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['username']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid parameters']);
        exit();
    }

    $username = $data['username'];
    $password = $data['password'];

    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "industri";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(['error' => 'Database connection error: ' . $conn->connect_error]);
        die();
    }

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result === false) {
        http_response_code(500);
        echo json_encode(['error' => 'Database query error: ' . $conn->error]);
        $conn->close();
        die();
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = [
            'username' => $row['username'],
            'name' => $row['name'],
            'email' => $row['email'],
        ];

        echo json_encode($response);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
    }

    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request method']);
}
?>
