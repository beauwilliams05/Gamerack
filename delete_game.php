<?php
$conn = new mysqli("localhost", "root", "", "gamerack");

if($conn->connect_error){
    echo "Failed to connect to DB" . $conn->connect_error;
}

// which game to delete (sent by the hidden field)
$id = $_POST['id'];

// prepared statement, same pattern as the other files
$stmt = $conn->prepare("DELETE FROM games WHERE id=?");
$stmt->bind_param("i", $id);

if($stmt->execute()){
    echo "Game deleted. <a href='games.php'>View My Games</a>";
}
else{
    echo "Failed to delete game.";
}

$stmt->close();
$conn->close();
?>