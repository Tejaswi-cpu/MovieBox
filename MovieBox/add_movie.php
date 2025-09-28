<?php
session_start();
require 'includes/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Initialize message
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $show_id = trim($_POST['show_id']);
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $director = trim($_POST['director']);
    $release_year = intval($_POST['release_year']);
    $image = trim($_POST['image']); // URL

    // Prepare statement, use backticks for `type` (reserved word)
    $stmt = $mysqli->prepare("
        INSERT INTO netflix_titles (show_id, title, `type`, director, release_year)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("sssss", $show_id, $title, $genre, $director, $release_year);

    if ($stmt->execute()) {
        $message = "<p style='color:green;'>✅ Movie added successfully!</p>";
    } else {
        $message = "<p style='color:red;'>❌ Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Movie - MovieBox</title>
<style>
    body { font-family: Arial; background-color:#141414; color:#fff; padding:20px; }
    h2 { text-align:center; color:#e50914; }
    form { max-width:400px; margin:auto; background:#1e1e1e; padding:20px; border-radius:8px; }
    input, button { width:100%; padding:10px; margin:8px 0; border-radius:5px; border:none; }
    input { background:#333; color:#fff; }
    button { background:#e50914; color:white; cursor:pointer; }
    .message { text-align:center; margin-bottom:10px; }
</style>
</head>
<body>

<h2>Add Movie</h2>

<div class="message"><?php echo $message; ?></div>

<form method="post">
    <input type="text" name="show_id" placeholder="Show ID" required>
    <input type="text" name="title" placeholder="Title" required>
    <input type="text" name="genre" placeholder="Genre / Type">
    <input type="text" name="director" placeholder="Director">
    <input type="number" name="release_year" placeholder="Release Year">
    <input type="text" name="image" placeholder="Enter full image URL">
    <button type="submit">Add Movie</button>
</form>

</body>
</html>
