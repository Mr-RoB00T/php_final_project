<?php

// Require files
require 'config.php';
require 'functions.php';

// Connect to database 
$db = db_connect();

// Check for form submit
if($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Get form data
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  // Validate input
  if(empty($email) || empty($password)) {
    $error = 'Please enter your email and password.';
  }
  else {

    // Check if email exists
    if(!user_exists($email)) {
      $error = 'Email not found.';
    }
    else {

      // Get user from database
      $sql = "SELECT * FROM users WHERE email=:email LIMIT 1";
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':email', $email);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      // Verify password
      if(!password_verify($password, $user['password'])) {
        $error = 'Incorrect password.';
      }
      else {
        // Login successful
        
        // Start session
        session_start();

        // Store user ID and name in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        // Redirect to dashboard
        header('Location: dashboard.php');
        exit;
      }

    }

  }

}

?>

<?php include 'header.php'; ?>

<h1>Login</h1>

<?php if(!empty($error)): ?>
  <div class="error"><?php echo $error; ?></div>  
<?php endif; ?>

<form method="post">

  <input type="email" name="email" placeholder="Enter your email" value="<?php echo $_POST['email'] ?? ''; ?>">

  <input type="password" name="password" placeholder="Enter your password">

  <button type="submit">Login</button>
  
</form>

<?php include 'footer.php'; ?>