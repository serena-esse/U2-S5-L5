<?php

/**
 * Classe Registration
 * gestisce la registrazione dell'utente
 */
class Registration
{
    /**
     * @var object $db_connection La connessione al database
     */
    private $db_connection = null;
    /**
     * @var array $errors Collezione di messaggi di errore
     */
    public $errors = array();
    /**
     * @var array $messages Collezione di messaggi di successo / neutrali
     */
    public $messages = array();

    /**
     * la funzione "__construct()" parte automaticamente ogni volta che un oggetto di questa classe viene creato,
     * sai, quando fai "$registration = new Registration();"
     */
    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    /**
     * gestisce l'intero processo di registrazione. controlla tutte le possibilità di errore
     * e crea un nuovo utente nel database se tutto è corretto
     */
    private function registerNewUser()
    {
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Nome utente vuoto";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->errors[] = "Password vuota";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "La password e la conferma della password non corrispondono";
        } elseif (strlen($_POST['user_password_new']) < 6) {
            $this->errors[] = "La password deve avere una lunghezza minima di 6 caratteri";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->errors[] = "Il nome utente non può essere più corto di 2 o più lungo di 64 caratteri";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->errors[] = "Il nome utente non corrisponde allo schema del nome: sono ammessi solo caratteri a-Z e numeri, da 2 a 64 caratteri";
        } elseif (empty($_POST['user_email'])) {
            $this->errors[] = "L'email non può essere vuota";
        } elseif (strlen($_POST['user_email']) > 64) {
            $this->errors[] = "L'email non può essere più lunga di 64 caratteri";
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Il tuo indirizzo email non è in un formato email valido";
        } elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            // crea una connessione al database
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // cambia il set di caratteri in utf8 e controlla
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // se non ci sono errori di connessione (= connessione al database funzionante)
            if (!$this->db_connection->connect_errno) {

                // escape, rimuovendo inoltre tutto ciò che potrebbe essere codice (html/javascript)
                $user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
                $user_email = $this->db_connection->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));

                $user_password = $_POST['user_password_new'];

                // crittografa la password dell'utente con la funzione password_hash() di PHP 5.5, risultati in una stringa hash di 60 caratteri
                // la costante PASSWORD_DEFAULT è definita da PHP 5.5, o se stai usando
                // PHP 5.3/5.4, dalla libreria di compatibilità per l'hashing delle password
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                // controlla se l'utente o l'indirizzo email esistono già
                $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';";
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) {
                    $this->errors[] = "Spiacenti, quel nome utente / indirizzo email è già in uso.";
                } else {
                    // scrive i dati del nuovo utente nel database
                    $sql = "INSERT INTO users (user_name, user_password_hash, user_email)
                            VALUES('" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "');";
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // se l'utente è stato aggiunto con successo
                    if ($query_new_user_insert) {
                        $this->messages[] = "Il tuo account è stato creato con successo. Ora puoi effettuare il login.";
                    } else {
                        $this->errors[] = "Spiacenti, la tua registrazione non è riuscita. Torna indietro e riprova.";
                    }
                }
            } else {
                $this->errors[] = "Spiacenti, nessuna connessione al database.";
            }
        } else {
            $this->errors[] = "Si è verificato un errore sconosciuto.";
        }
    }
}
?>
