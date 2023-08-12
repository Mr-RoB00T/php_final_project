<?php

// Require files
require 'config.php';
require 'functions.php';

// Connect to database 
$db = db_connect();

// Get posts
$stmt = $db->query("SELECT p.*, u.name AS author FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
$posts = $stmt->fetchAll();

?>

<?php include 'header.php'; ?>

<div class="content">

  <h1>My Blog</h1>
  
  <?php if (count($posts) > 0): ?>

    <?php foreach ($posts as $post): ?>
    
      <article class="post">
        <h2><?php echo $post['title']; ?></h2>
        <p class="post-author">Posted by <?php echo $post['author']; ?> on <?php echo $post['created_at']; ?></p>
        <p><?php echo $post['body']; ?></p>
      </article>
    
    <?php endforeach; ?>

  <?php else: ?>

    <p>No posts found.</p>

  <?php endif; ?>

</div>

<?php include 'footer.php'; ?>