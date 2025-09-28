<?php
session_start();
require 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$show_id = $_GET['id']; // URL मधून show_id मिळणार

$stmt = $mysqli->prepare("INSERT INTO watchlist (user_id, show_id) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $show_id);
$stmt->execute();

header("Location: watchlist.php");
exit;
?>
