<?php
// Include il file di configurazione del database
require_once("config/db.php");

// Load the login class
require_once("classes/Login.php");

// Create a login object
$login = new Login();

// Check if the user is logged in
if ($login->isUserLoggedIn() == true) {
    // Include code to manage books
    require_once("manage_books.php");

    // Include the logged in view
    include("views/logged_in.php");
} else {
    // Include the not logged in view
    include("views/not_logged_in.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Books Management</h2>

    <!-- Form to add a new book -->
    <form action="index.php" method="post">
        <h3>Add a New Book</h3>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required><br>
        <label for="year">Year:</label>
        <input type="number" id="year" name="year" required><br>
        <button type="submit" name="add_book">Add Book</button>
    </form>

    <!-- Table to display books -->
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Year</th>
            <th>Action</th>
        </tr>
        <?php foreach ($books as $book) : ?>
            <tr>
                <td><?= $book['title'] ?></td>
                <td><?= $book['author'] ?></td>
                <td><?= $book['year'] ?></td>
                <td>
                    <form action="index.php" method="post">
                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                        <button type="submit" name="delete_book">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>