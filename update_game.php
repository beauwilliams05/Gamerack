<?php
$conn = new mysqli("localhost", "root", "", "gamerack");

if($conn->connect_error){
    echo "Failed to connect to DB" . $conn->connect_error;
}

$id = $_POST['id'];
$title = $_POST['title'];
$platform = $_POST['platform'];
$genre = $_POST['genre'];
$status = $_POST['status'];
$hours = $_POST['hours'];

$stmt = $conn->prepare("UPDATE games SET title=?, platform=?, genre=?, status=?, hours=? WHERE id=?");

// 4 strings, 2 integers (hours and id)
$stmt->bind_param("ssssii", $title, $platform, $genre, $status, $hours, $id);

if($stmt->execute()){
    echo "Game updated. <a href='games.php'>View My Games</a>";
}
else{
    echo "Failed to update game.";
}

$stmt->close();
$conn->close();
?>