<?php
require_once 'config/database.php';
require_once 'config/session.php';

// Require login to view posts
requireLogin();

$connection = getDBConnection();

// Get all posts with user information
$stmt = $connection->prepare("
    SELECT p.id, p.title, p.content, p.created_at, p.user_id, u.username 
    FROM posts p 
    JOIN users u ON p.user_id = u.id 
    ORDER BY p.created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
closeDBConnection($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts - BlogApp</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="posts-header">
            <h1>All Blog Posts</h1>
            <a href="create_post.php" class="btn btn-primary">Create New Post</a>
        </div>
        
        <?php if (empty($posts)): ?>
            <div class="no-posts">
                <p>No posts found. <a href="create_post.php">Create the first post!</a></p>
            </div>
        <?php else: ?>
            <div class="posts-grid">
                <?php foreach ($posts as $post): ?>
                    <div class="post-card">
                        <div class="post-header">
                            <h3 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                            <div class="post-meta">
                                <span class="post-author">By <?php echo htmlspecialchars($post['username']); ?></span>
                                <span class="post-date"><?php echo date('M j, Y', strtotime($post['created_at'])); ?></span>
                            </div>
                        </div>
                        
                        <div class="post-content">
                            <?php 
                            $content = htmlspecialchars($post['content']);
                            echo strlen($content) > 200 ? substr($content, 0, 200) . '...' : $content;
                            ?>
                        </div>
                        
                        <?php if ($post['user_id'] == getCurrentUserId()): ?>
                            <div class="post-actions">
                                <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-secondary btn-sm">Edit</a>
                                <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
