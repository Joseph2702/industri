<?php
// get_user.php
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "industri";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = [];

    while ($row = $result->fetch_assoc()) {
        $user[] = [
            'user_id' => $row['user_id'],  // Change 'userid' to 'user_id'
            'username' => $row['username'],
            'name' => $row['name'],
            'email' => $row['email'],
        ];
    }

    echo json_encode($user);
} else {
    echo json_encode([]);
}

$conn->close();

?>
