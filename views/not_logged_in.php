<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
}
?>

<!-- login form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione dei Libri</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form method="post" action="index.php" name="loginform" class="mt-5">
        <div class="form-group">
          <label for="login_input_username">Username</label>
          <input id="login_input_username" class="form-control" type="text" name="user_name" required />
        </div>
        <div class="form-group">
          <label for="login_input_password">Password</label>
          <input id="login_input_password" class="form-control" type="password" name="user_password" autocomplete="off" required />
        </div>
        <button type="submit" name="login" class="btn btn-primary">Log in</button>
      </form>
      <div class="mt-3">
        <a href="register.php">Register new account</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
