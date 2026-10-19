<?php
$conn = new mysqli("localhost", "root", "", "gamerack");

if($conn->connect_error){
    echo "Failed to connect to DB" . $conn->connect_error;
}

// which game was clicked (comes from the link: edit_game.php?id=3)
$id = $_GET['id'];

// prepared statement, so the id can't be used for SQL injection
$stmt = $conn->prepare("SELECT * FROM games WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameRack | Edit Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- navigation bar -->
    <nav class="main-nav">
        <ul>
            <li><a href="games.php">My Games</a></li>
            <li><a href="game_form.html">Add Game</a></li>
            <li><a href="account.html">Account</a></li>
        </ul>
    </nav>

    <main class="page">
        <h1>Edit Game</h1>

        <form class="form-box" action="update_game.php" method="post">
            <!-- hidden field so update_game.php knows which game this is -->
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>

            <label for="platform">Platform</label>
            <select id="platform" name="platform" required>
                <option value="PC" <?php echo ($row['platform'] === "PC") ? "selected" : ""; ?>>PC</option>
                <option value="PlayStation" <?php echo ($row['platform'] === "PlayStation") ? "selected" : ""; ?>>PlayStation</option>
                <option value="Xbox" <?php echo ($row['platform'] === "Xbox") ? "selected" : ""; ?>>Xbox</option>
                <option value="Switch" <?php echo ($row['platform'] === "Switch") ? "selected" : ""; ?>>Switch</option>
            </select>

            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($row['genre']); ?>" required>

            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="Unplayed" <?php echo ($row['status'] === "Unplayed") ? "selected" : ""; ?>>Unplayed</option>
                <option value="Playing" <?php echo ($row['status'] === "Playing") ? "selected" : ""; ?>>Playing</option>
                <option value="Completed" <?php echo ($row['status'] === "Completed") ? "selected" : ""; ?>>Completed</option>
            </select>

            <label for="hours">Hours Played</label>
            <input type="number" id="hours" name="hours" value="<?php echo $row['hours']; ?>" min="0" required>

            <button type="submit">Update Game</button>
        </form>

        <p><a href="games.php">Cancel</a></p>
    </main>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>