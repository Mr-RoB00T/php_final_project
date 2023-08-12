<?php

// Require files
require 'config.php';
require 'functions.php'; 

// Require login
require_login();

// Connect to database
$db = db_connect();

// Check for form submit
if(isset($_POST['submit'])) {

  // Get form data
  $id = $_POST['id'];
  $title = $_POST['title'];
  $body = $_POST['body'];

  // Validate input
  if(empty($title)) {
    $error = 'Please enter a title';
  }
  else if(empty($body)) {
    $error = 'Please enter the body content';
  }
  else {

    // Update post in database
    $sql = "UPDATE posts SET title=:title, body=:body WHERE id=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':body', $body);  
    $stmt->execute();

    // Redirect to dashboard
    header('Location: dashboard.php');
    exit;

  }

}

// Get ID of post to edit
$id = $_GET['id'] ?? null;

if($id) {

  // Get post from database
  $sql = "SELECT * FROM posts WHERE id=:id";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':id', $id);
  $stmt->execute();
  $post = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check if post exists
  if(!$post) {
    die ("Post not found");
  }

  // Pre-fill form values  
  $title = $post['title'];
  $body = $post['body'];

} else {
  // Redirect if no valid ID
  header('Location: dashboard.php');
  exit;
}

?>

<?php include 'header.php'; ?>

<h2>Edit Post</h2>

<?php if(!empty($error)): ?>
  <p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<form method="post">

  <input type="hidden" name="id" value="<?php echo $post['id']; ?>">

  <input name="title" placeholder="Enter title" value="<?php echo $title; ?>">

  <textarea name="body" placeholder="Enter post body"><?php echo $body; ?></textarea>

  <button type="submit" name="submit">Update Post</button>

</form>

<?php include 'footer.php'; ?>