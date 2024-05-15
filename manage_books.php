<?php
// Include il file di configurazione del database
require_once("config/db.php");

// Crea la connessione al database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica se la connessione al database è stata stabilita correttamente
if (!$conn) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

// Verifica se è stato inviato il modulo di aggiunta di un nuovo libro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_book"])) {
    // Recupera i dati inviati dal modulo
    $title = $_POST["title"];
    $author = $_POST["author"];
    $year = $_POST["year"];

    // Esegui la query per aggiungere un nuovo libro
    $query = "INSERT INTO books (title, author, year) VALUES ('$title', '$author', '$year')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Libro aggiunto con successo
        echo "Libro aggiunto con successo.";
    } else {
        // Errore durante l'aggiunta del libro
        echo "Si è verificato un errore durante l'aggiunta del libro: " . mysqli_error($conn);
    }
}

// Verifica se è stato inviato il modulo di eliminazione di un libro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_book"])) {
    // Recupera l'ID del libro da eliminare
    $book_id = $_POST["book_id"];

    // Esegui la query per eliminare il libro
    $query = "DELETE FROM books WHERE id = '$book_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Libro eliminato con successo
        echo "Libro eliminato con successo.";
    } else {
        // Errore durante l'eliminazione del libro
        echo "Si è verificato un errore durante l'eliminazione del libro: " . mysqli_error($conn);
    }
}

// Recupera i libri dal database
$query = "SELECT * FROM books";
$result = mysqli_query($conn, $query);

// Inizializza un array per contenere i libri
$books = [];

// Verifica se ci sono risultati dalla query
if ($result && mysqli_num_rows($result) > 0) {
    // Popola l'array $books con i dati dei libri
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
}

// Chiudi la connessione al database solo se è stata aperta correttamente
if ($conn && mysqli_ping($conn)) {
    mysqli_close($conn);
}
?>
