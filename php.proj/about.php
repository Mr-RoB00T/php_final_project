<?php 

// Require files
require 'config.php';
require 'functions.php';

// Connect to DB
$db = db_connect();

// Get page data from DB
$about = $db->query("SELECT * FROM pages WHERE slug = 'about'")->fetch();

// Get recent posts
$posts = $db->query("SELECT id, title, subtitle, created_at FROM posts ORDER BY created_at DESC LIMIT 3")->fetchAll();

?>

<?php include 'header.php'; ?>

<div class="page-content">

  <?php if($about['image']): ?>
    <img src="<?php echo $about['image']; ?>" class="page-hero">
  <?php endif; ?>

  <h1><?php echo $about['title']; ?></h1>

  <?php if($about['subtitle']): ?>
    <p class="page-subtitle"><?php echo $about['subtitle']; ?></p> 
  <?php endif; ?>

  <?php echo $about['content']; ?>

  <h2>Recent Posts</h2>

  <ul class="recent-posts">

    <?php foreach ($posts as $post): ?>
      <li>
        <a href="post.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a>
        <span><?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
      </li>
    <?php endforeach; ?>

  </ul>

</div>

<?php include 'footer.php'; ?>