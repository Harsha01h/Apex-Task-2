<?php
require_once 'config/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogApp - Share Your Thoughts</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="hero">
            <h1>Welcome to BlogApp</h1>
            <p>Share your thoughts, ideas, and stories with the world</p>
            
            <?php if (isLoggedIn()): ?>
                <a href="posts.php" class="btn btn-primary">View All Posts</a>
                <a href="create_post.php" class="btn btn-secondary">Create New Post</a>
            <?php else: ?>
                <a href="signup.php" class="btn btn-primary">Get Started</a>
                <a href="login.php" class="btn btn-secondary">Login</a>
            <?php endif; ?>
        </div>
        
        <div class="features">
            <div class="feature-grid">
                <div class="feature-card">
                    <h3>Easy to Use</h3>
                    <p>Simple and intuitive interface for creating and managing your blog posts.</p>
                </div>
                
                <div class="feature-card">
                    <h3>Secure</h3>
                    <p>Your data is protected with secure authentication and password hashing.</p>
                </div>
                
                <div class="feature-card">
                    <h3>Responsive</h3>
                    <p>Works perfectly on desktop, tablet, and mobile devices.</p>
                </div>
            </div>
        </div>
        
        <?php if (isLoggedIn()): ?>
            <div class="welcome-back">
                <h2>Welcome back, <?php echo htmlspecialchars(getCurrentUsername()); ?>!</h2>
                <p>Ready to share something new with the world?</p>
                <div class="quick-actions">
                    <a href="create_post.php" class="btn btn-primary">Write a Post</a>
                    <a href="posts.php" class="btn btn-secondary">Browse Posts</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
