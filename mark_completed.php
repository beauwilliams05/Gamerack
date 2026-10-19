<?php
$conn = new mysqli("localhost", "root", "", "gamerack");

if($conn->connect_error){
    echo "Failed to connect to DB" . $conn->connect_error;
}

// which game
$id = $_POST['id'];

$stmt = $conn->prepare("UPDATE games SET status='Completed' WHERE id=?");
$stmt->bind_param("i", $id);

if($stmt->execute()){
    echo "Game marked as completed. <a href='games.php'>View My Games</a>";
}
else{
    echo "Failed to update game.";
}

$stmt->close();
$conn->close();
?>