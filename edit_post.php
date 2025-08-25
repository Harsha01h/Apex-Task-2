<?php
require_once 'config/database.php';
require_once 'config/session.php';

// Require login to edit posts
requireLogin();

$error = '';
$success = '';
$post = null;

// Get post ID from URL
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($post_id <= 0) {
    header('Location: posts.php');
    exit();
}

$connection = getDBConnection();

// Get post and verify ownership
$stmt = $connection->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$user_id = getCurrentUserId();
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $stmt->close();
    closeDBConnection($connection);
    header('Location: posts.php');
    exit();
}

$post = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    
    // Validation
    if (empty($title) || empty($content)) {
        $error = 'Title and content are required.';
    } elseif (strlen($title) > 255) {
        $error = 'Title must be less than 255 characters.';
    } else {
        // Update post
        $stmt = $connection->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $title, $content, $post_id, $user_id);
        
        if ($stmt->execute()) {
            $success = 'Post updated successfully!';
            // Update local post data
            $post['title'] = $title;
            $post['content'] = $content;
        } else {
            $error = 'Error updating post. Please try again.';
        }
        
        $stmt->close();
    }
}

closeDBConnection($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - BlogApp</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="form-container">
            <h2>Edit Post</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                    <a href="posts.php">View all posts</a>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Post</button>
                    <a href="posts.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
