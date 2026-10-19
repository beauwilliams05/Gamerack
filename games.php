<?php
// connect to the database (same connection as the class demos)
$conn = new mysqli("localhost", "root", "", "gamerack");

if($conn->connect_error){
    echo "Failed to connect to DB" . $conn->connect_error;
}

// get every game from the table
$results = $conn->query("SELECT * FROM games");

// read the filter choices from the filter input
$status = isset($_GET['status']) ? $_GET['status'] : "";
$platform = isset($_GET['platform']) ? $_GET['platform'] : "";
$genre = isset($_GET['genre']) ? $_GET['genre'] : "";

// code for filter autofill (the % autofill so "ti" would showe "Action", but it also shows other genres that contain exactly "ti")
$genreLike = "%" . $genre . "%";

// a blank filter matches everything, otherwise it must match
$stmt = $conn->prepare("SELECT * FROM games WHERE (status = ? OR ? = '') AND (platform = ? OR ? = '') AND genre LIKE ?");
$stmt->bind_param("sssss", $status, $status, $platform, $platform, $genreLike);
$stmt->execute();
$results = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameRack | My Games</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>

    <!-- navigation bar links -->
    <nav class="main-nav">
        <ul>
            <li><a href="games.php">My Games</a></li>
            <li><a href="game_form.html">Add Game</a></li>
            <li><a href="account.html">Account</a></li>
        </ul>
    </nav>

    <main class="page">
        <h1>My Games</h1>

        <!-- Filter bar -->
        <form class="filter-bar" id="filterForm" method="get" action="games.php">
            <label for="filterStatus">Status</label>
            <select id="filterStatus" name="status">
                <option value="">All</option>
                <option value="Unplayed">Unplayed</option>
                <option value="Playing">Playing</option>
                <option value="Completed">Completed</option>
            </select>

            <label for="filterPlatform">Platform</label>
            <select id="filterPlatform" name="platform">
                <option value="">All</option>
                <option value="PC">PC</option>
                <option value="PlayStation">PlayStation</option>
                <option value="Xbox">Xbox</option>
                <option value="Switch">Switch</option>
            </select>

            <label for="filterGenre">Genre</label>
            <input type="text" id="filterGenre" name="genre" placeholder="e.g. RPG">

            <button type="submit">Filter</button>
        </form>

        <!-- game list, built from the database -->
        <table border="1" id="gameTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Platform</th>
                    <th>Genre</th>
                    <th>Status</th>
                    <th>Hours</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($results->num_rows > 0){
                    // builds one table row for every game in the database
                    while($row = $results->fetch_assoc()){
                        $id = $row['id'];
                        //htmlspecialchars() prevents names like "<script>..." from getting run as code (credit to VS code autofill and Google)
                        $title = htmlspecialchars($row['title']);
                        $platform = htmlspecialchars($row['platform']);
                        $genre = htmlspecialchars($row['genre']);
                        $status = htmlspecialchars($row['status']);
                        $hours = $row['hours'];

                        echo "<tr id='row{$id}'>
                            <td>{$title}</td>
                            <td id='platform{$id}'>{$platform}</td>
                            <td id='genre{$id}'>{$genre}</td>
                            <td id='status{$id}'>{$status}</td>
                            <td>{$hours}</td>
                            <td>
                                <a href='edit_game.php?id={$id}'>Edit</a>
                                <form method='post' action='mark_completed.php' class='delete-button'>
                                    <input type='hidden' name='id' value='{$id}'>
                                    <button type='submit'>Mark Completed</button>
                                </form>
                                <form method='post' action='delete_game.php' class='delete-button' onsubmit=\"return confirm('Delete this game?')\">
                                    <input type='hidden' name='id' value='{$id}'>
                                    <button type='submit'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                }
                else{
                    echo "<tr><td colspan='6'>No games found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <p><a href="game_form.html">+ Add a new game</a></p>
    </main>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>