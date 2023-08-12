<?php

// Require files
require 'config.php';  
require 'functions.php';

// Require login
require_login();

// Connect to database
$db = db_connect();

// Get user info from session
$user_id = $_SESSION['user_id'];
$user = get_user($user_id); 

// Get site analytics
$pageviews_today = get_pageviews(strtotime('today'));
$pageviews_this_month = get_pageviews(strtotime('first day of this month'));
$users_count = get_users_count();
$posts_count = get_posts_count();

// Get recent posts
$recent_posts = get_recent_posts(5);

?>

<?php include 'header.php'; ?>

<h1>Dashboard</h1>

<p>Welcome back, <?php echo $user['name']; ?>!</p>

<div class="info-boxes">

  <div class="box">
    <h3><?php echo $pageviews_today; ?></h3>
    <p>Pageviews Today</p> 
  </div>
  
  <div class="box">
    <h3><?php echo $pageviews_this_month; ?></h3>
    <p>Pageviews This Month</p>
  </div>

  <div class="box">
    <h3><?php echo $users_count; ?></h3>    
    <p>Registered Users</p>
  </div>

  <div class="box">
    <h3><?php echo $posts_count; ?></h3>
    <p>Total Posts</p>
  </div>

</div>

<h2>Recent Posts</h2>

<table>
  <thead>
    <tr>
      <th>Title</th>
      <th>Published</th>
    </tr>
  </thead>
  <tbody>

    <?php foreach ($recent_posts as $post): ?>
      <tr>
        <td><?php echo $post['title']; ?></td>
        <td><?php echo format_date($post['published_at']); ?></td>
      </tr>
    <?php endforeach; ?>

  </tbody>
</table>

<a href="posts.php" class="btn">Manage Posts</a>

<?php include 'footer.php'; ?>