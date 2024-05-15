<?php
// Include il file di configurazione del database
require_once("config/db.php");

// Carica la classe di login
require_once("classes/Login.php");

// Crea un oggetto di login
$login = new Login();

// Verifica se l'utente è loggato
if ($login->isUserLoggedIn() == true) {
    // Include il codice per gestire i libri
    require_once("manage_books.php");

    // Include la vista per gli utenti loggati
    include("views/logged_in.php");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione dei Libri</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Gestione dei Libri</h2>

    <!-- Modulo per aggiungere un nuovo libro -->
    <form action="index.php" method="post">
        <h3>Aggiungi un Nuovo Libro</h3>
        <label for="title">Titolo:</label>
        <input type="text" id="title" name="title" required><br>
        <label for="author">Autore:</label>
        <input type="text" id="author" name="author" required><br>
        <label for="year">Anno:</label>
        <input type="number" id="year" name="year" required><br>
        <button type="submit" name="add_book">Aggiungi Libro</button>
    </form>

    <!-- Tabella per visualizzare i libri -->
    <table border="1">
        <tr>
            <th>Titolo</th>
            <th>Autore</th>
            <th>Anno</th>
            <th>Azione</th>
        </tr>
        <?php foreach ($books as $book) : ?>
            <tr>
                <td><?= $book['title'] ?></td>
                <td><?= $book['author'] ?></td>
                <td><?= $book['year'] ?></td>
                <td>
                    <form action="index.php" method="post">
                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                        <button type="submit" name="delete_book">Elimina</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>

<?php
} else {
    // L'utente non è loggato, quindi non includere nulla o reindirizzalo ad una pagina di accesso
    header("Location: login.php"); // Reindirizza alla pagina di login
    exit; // Assicura che lo script non continui dopo il reindirizzamento
}
?>
