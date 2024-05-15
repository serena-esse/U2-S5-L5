<?php
// mostra eventuali errori / feedback (dall'oggetto di login)
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

<!-- Casella del modulo di accesso -->
<form method="post" action="index.php" name="loginform">

    <label for="login_input_username">Nome utente</label>
    <input id="login_input_username" class="login_input" type="text" name="user_name" required />

    <label for="login_input_password">Password</label>
    <input id="login_input_password" class="login_input" type="password" name="user_password" autocomplete="off" required />

    <input type="submit"  name="login" value="Accedi" />

</form>

<a href="register.php">Registrati per un nuovo account</a>
