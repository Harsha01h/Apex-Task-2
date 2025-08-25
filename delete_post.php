<?php
require_once 'config/database.php';
require_once 'config/session.php';

// Require login to delete posts
requireLogin();

// Get post ID from URL
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($post_id <= 0) {
    header('Location: posts.php');
    exit();
}

$connection = getDBConnection();

// Verify ownership and delete post
$stmt = $connection->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
$user_id = getCurrentUserId();
$stmt->bind_param("ii", $post_id, $user_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    // Post deleted successfully
    $_SESSION['message'] = 'Post deleted successfully.';
} else {
    // Post not found or not owned by user
    $_SESSION['error'] = 'Post not found or you do not have permission to delete it.';
}

$stmt->close();
closeDBConnection($connection);

// Redirect back to posts page
header('Location: posts.php');
exit();
?>
