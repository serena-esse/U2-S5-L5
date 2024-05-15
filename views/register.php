<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}
?>

<!-- register form -->
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
      <form method="post" action="register.php" name="registerform" class="mt-5">
        <div class="form-group">
          <label for="login_input_username">Username (only letters and numbers, 2 to 64 characters)</label>
          <input id="login_input_username" class="form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
        </div>
        <div class="form-group">
          <label for="login_input_email">User's email</label>
          <input id="login_input_email" class="form-control" type="email" name="user_email" required />
        </div>
        <div class="form-group">
          <label for="login_input_password_new">Password (min. 6 characters)</label>
          <input id="login_input_password_new" class="form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
        </div>
        <div class="form-group">
          <label for="login_input_password_repeat">Repeat password</label>
          <input id="login_input_password_repeat" class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
        </div>
        <button type="submit" name="register" class="btn btn-primary">Register</button>
      </form>
      <div class="mt-3">
        <a href="index.php">Back to Login Page</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>