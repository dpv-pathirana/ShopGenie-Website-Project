<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];

    // Password validation checks
    $uppercase = preg_match('@[A-Z]@', $pass);
    $lowercase = preg_match('@[a-z]@', $pass);
    $number = preg_match('@[0-9]@', $pass);
    $specialChars = preg_match('@[^\w]@', $pass);
    $minLength = strlen($pass) >= 8;

    $errors = array();

    if (!$uppercase) {
        $errors[] = '<div class="message">Password must contain at least one uppercase letter.</div>';
    }

    if (!$lowercase) {
        $errors[] = '<div class="message">Password must contain at least one lowercase letter.</div>';
    }

    if (!$number) {
        $errors[] = '<div class="message">Password must contain at least one digit.</div>';
    }

    if (!$specialChars) {
        $errors[] = '<div class="message">Password must contain at least one special character.</div>';
    }

    if (!$minLength) {
        $errors[] = '<div class="message">Password must be at least 8 characters long.</div>';
    }

    if ($pass !== $cpass) {
        $errors[] = '<div class="message">Passwords do not match.</div>';
    }

    if (!empty($errors)) {
        // If there are errors, display them to the user
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
    } else {
        // If the password is valid, proceed with database operations
        $pass = mysqli_real_escape_string($conn, md5($pass));

        $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email'") or die('query failed');

        if (mysqli_num_rows($select) > 0) {
            echo 'User already exists!';
        } else {
            mysqli_query($conn, "INSERT INTO `user_form`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
            echo 'Registered successfully!';
            header('location: login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="enter username" class="box">
      <input type="email" name="email" required placeholder="enter email" class="box">
      <input type="password" name="password" required placeholder="enter password" class="box">
      <input type="password" name="cpassword" required placeholder="confirm password" class="box">
      <input type="submit" name="submit" class="btn" value="register now">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</div>

</body>
</html>