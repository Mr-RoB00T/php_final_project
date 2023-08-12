<?php

// Require files
require 'config.php';
require 'functions.php';

// Require login 
require_login(); 

// Connect to database
$db = db_connect();

// Check for form submit
if($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Get form data
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
  
    // Insert post into database
    $sql = "INSERT INTO posts(title, body) VALUES(:title, :body)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':body', $body);
    $stmt->execute();

    // Redirect to dashboard
    header('Location: dashboard.php'); 
    exit;

  }

}

?>

<?php include 'header.php'; ?>  

<h2>Add Post</h2>

<?php if (!empty($error)): ?>
  <p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<form method="post">

  <input name="title" placeholder="Enter title" value="<?php echo $_POST['title'] ?? ''; ?>">

  <textarea name="body" placeholder="Enter post body"><?php echo $_POST['body'] ?? ''; ?></textarea>

  <button type="submit">Publish Post</button>

</form>

<?php include 'footer.php'; ?>