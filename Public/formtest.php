<?PHP
  // form handler
  if($_POST && isset($_POST['sendfeedback'], $_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if(!$name) {
      $errorMsg = "Please enter your Name";
    } elseif(!$email || !preg_match("/^\S+@\S+$/", $email)) {
      $errorMsg = "Please enter a valid Email address";
    } elseif(!$message) {
      $errorMsg = "Please enter your comment in the Message box";
    } else {
      // send email and redirect
      $to = "feedback@example.com";
      if(!$subject) $subject = "Contact from website";
      $headers = "From: webmaster@example.com" . "\r\n";
      mail($to, $subject, $message, $headers);
      header("Location: http://www.example.com/thankyou.html");
      exit;
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Test</title>
</head>
<body>
  
<form method="POST" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" accept-charset="UTF-8">
<p><label>Your Name<strong>*</strong><br>
<input type="text" size="48" name="name" value="<?PHP if(isset($_POST['name'])) echo htmlspecialchars($_POST['name']); ?>"></label></p>
<p><label>Email Address<strong>*</strong><br>
<input type="email" size="48" name="email" value="<?PHP if(isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>"></label></p>
<p><label>Subject<br>
<input type="text" size="48" name="subject" value="<?PHP if(isset($_POST['subject'])) echo htmlspecialchars($_POST['subject']); ?>"></label></p>
<p><label>Enquiry<strong>*</strong><br>
<textarea name="message" cols="48" rows="8"><?PHP if(isset($_POST['message'])) echo htmlspecialchars($_POST['message']); ?></textarea></label></p>
<p><input type="submit" name="sendfeedback" value="Send Message"></p>
</form>
</body>
</html>
