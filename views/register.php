<?php
// mostra eventuali errori / feedback (dall'oggetto di registrazione)
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

<!-- Modulo di registrazione -->
<form method="post" action="register.php" name="registerform">

    <!-- Il campo di input del nome utente utilizza un controllo del modello HTML5 -->
    <label for="login_input_username">Nome utente (solo lettere e numeri, da 2 a 64 caratteri)</label>
    <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />

    <!-- Il campo di input dell'email utente utilizza un controllo del tipo email HTML5 -->
    <label for="login_input_email">Email dell'utente</label>
    <input id="login_input_email" class="login_input" type="email" name="user_email" required />

    <label for="login_input_password_new">Password (min. 6 caratteri)</label>
    <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />

    <label for="login_input_password_repeat">Ripeti password</label>
    <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
    <input type="submit"  name="register" value="Registrati" />

</form>

<!-- Link per tornare alla pagina di accesso -->
<a href="index.php">Torna alla pagina di accesso</a>
