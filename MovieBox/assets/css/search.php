 <?php
session_start();
require 'includes/db_connect.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get search query
$search = "";
if (isset($_GET['q'])) {
    $search = trim($_GET['q']);
}

// Prepare SQL (search by title, director, or type)
$stmt = $mysqli->prepare("
    SELECT * FROM netflix_db.netflix_titles
    WHERE title LIKE ? OR director LIKE ? OR type LIKE ?");
$param = "%" . $search . "%";
$stmt->bind_param("sss", $param, $param, $param);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - MovieBox</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <img src="assets/img/moviebox.jpeg" alt="MovieBox Logo" class="logo-img">
                <span class="logo-text">MovieBox</span>
            </div>
            <div class="search-bar">
                <form method="get" action="search.php">
                    <input type="text" name="q" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="user-actions">
                <a href="index.php">Home</a>
                <a href="watchlist.php">Watchlist</a>
                <a href="add_movie.php">Add Movie</a>
                <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
            </div>
        </div>
    </div>

    <div class="movies-container">
        <h2>Search Results for "<?php echo htmlspecialchars($search); ?>"</h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($movie = $result->fetch_assoc()): ?>
                <div class="movie-card">
                    <?php if (!empty($movie['image'])): ?>
                        <img src="<?php echo htmlspecialchars($movie['image']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="movie-poster">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                    <p><strong>Type:</strong> <?php echo htmlspecialchars($movie['type']); ?></p>
                    <p><strong>Year:</strong> <?php echo htmlspecialchars($movie['release_year']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No movies found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
