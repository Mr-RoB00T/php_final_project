<?php

// Require files
require 'config.php';
require 'functions.php';

// Connect to database
$db = db_connect();

// Check for form submit
if($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Get form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  // Validate input
  if(empty($name) || empty($email) || empty($password)) {
    $error = 'Please fill out all fields.';
  }
  else if(filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
    $error = 'Please enter a valid email address.';
  }
  else if(user_exists($email)) {
    $error = 'Email already registered. <a href="login.php">Login</a> instead.'; 
  }
  else {
    
    // Hash password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user into database
    $sql = "INSERT INTO users(name, email, password) VALUES(:name, :email, :password)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);  
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    
    // Redirect to login page
    header('Location: login.php');
    exit;
    
  }
  
}

?>

<?php include 'header.php'; ?>

<h1>Register</h1>

<?php if(!empty($error)): ?>
  <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="post">

  <input type="text" name="name" placeholder="Name" value="<?php echo $_POST['name'] ?? ''; ?>">

  <input type="email" name="email" placeholder="Email" value="<?php echo $_POST['email'] ?? ''; ?>">

  <input type="password" name="password" placeholder="Password">

  <input type="password" name="confirm_password" placeholder="Confirm Password">

  <button type="submit">Register</button>
  
</form>

<?php include 'footer.php'; ?>