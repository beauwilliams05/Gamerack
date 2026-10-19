<?php
// connect to the database
$conn = new mysqli("localhost", "root", "", "gamerack");

if($conn->connect_error){
    echo "Failed to connect to DB" . $conn->connect_error;
}

// read what the form sent
$title = $_POST['title'];
$platform = $_POST['platform'];
$genre = $_POST['genre'];
$status = $_POST['status'];
$hours = $_POST['hours'];

// prepared statement: the ? marks get filled in safely (blocks SQL injection)
$stmt = $conn->prepare("INSERT INTO games(title, platform, genre, status, hours) VALUES(?, ?, ?, ?, ?)");

// s = string, i = integer (4 strings, then 1 integer)
$stmt->bind_param("ssssi", $title, $platform, $genre, $status, $hours);

if($stmt->execute()){
    echo "Game added to your library. <a href='games.php'>View My Games</a>";
}
else{
    echo "Failed to add game.";
}

$stmt->close();
$conn->close();
?>