<?php
// Include il file di configurazione del database
require_once("config/db.php");

// Load the login class
require_once("classes/Login.php");

// Create a login object
$login = new Login();

// Verifica se l'utente è loggato
if ($login->isUserLoggedIn() == true) {
    // Include code to manage books
    require_once("manage_books.php");

    // Include the logged in view
    include("views/logged_in.php");
} else {
    // Include the not logged in view
    include("views/not_logged_in.php");
    // Termina lo script per evitare che venga visualizzato il resto della pagina
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione dei Libri</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   
</head>
<body>
    

    <!-- Form to add a new book -->
    <div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Aggiungi un Nuovo Libro</h3>
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="title">Titolo:</label>
                    <input type="text" id="title" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="author">Autore:</label>
                    <input type="text" id="author" name="author" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="year">Anno:</label>
                    <input type="number" id="year" name="year" class="form-control" required>
                </div>
                <button type="submit" name="add_book" class="btn btn-primary">Aggiungi Libro</button>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Libri Aggiunti</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Titolo</th>
                        <th>Autore</th>
                        <th>Anno</th>
                        <th>Azione</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book) : ?>
                        <tr>
                            <td><?= $book['title'] ?></td>
                            <td><?= $book['author'] ?></td>
                            <td><?= $book['year'] ?></td>
                            <td>
                                <form action="index.php" method="post">
                                    <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                    <button type="submit" name="delete_book" class="btn btn-danger">Elimina</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
