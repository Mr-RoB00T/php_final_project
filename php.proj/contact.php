<?php

// Require header and footer
require 'header.php';
require 'footer.php';

// Check for form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Get form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  
  // Validate input
  if(empty($name) || empty($email) || empty($message)) {
    $error = 'Please fill out all fields.';
  }
  else {
    // Send email
    mail('me@example.com', 'Contact Form Submission', $message);
    
    // Set success message
    $success = 'Thanks for the message! I\'ll be in touch soon.';
  }

}

?>

<h1>Contact Me</h1>

<?php if(isset($error)): ?>
  <p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<?php if(isset($success)): ?>
  <p class="success"><?php echo $success; ?></p>  
<?php endif; ?>

<form method="post">

  <input type="text" name="name" placeholder="Name">

  <input type="email" name="email" placeholder="Email">

  <textarea name="message" placeholder="Message"></textarea>

  <button type="submit">Send</button>

</form>