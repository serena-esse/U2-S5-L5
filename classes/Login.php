<?php

/**
 * Classe Login
 * gestisce il processo di accesso e logout dell'utente
 */
class Login
{
    /**
     * @var object La connessione al database
     */
    private $db_connection = null;
    /**
     * @var array Collezione di messaggi di errore
     */
    public $errors = array();
    /**
     * @var array Collezione di messaggi di successo / neutrali
     */
    public $messages = array();

    /**
     * La funzione "__construct()" parte automaticamente ogni volta che un oggetto di questa classe viene creato,
     * quando fai "$login = new Login();"
     */
    public function __construct()
    {
        // crea/leggi la sessione, assolutamente necessario
        session_start();

        // controlla le azioni di login possibili:
        // se l'utente ha provato a fare il logout (avviene quando l'utente clicca sul pulsante di logout)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login tramite dati post (se l'utente ha appena inviato un modulo di accesso)
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    /**
     * accedi con i dati post
     */
    private function dologinWithPostData()
    {
        // controlla i contenuti del modulo di accesso
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Il campo Nome utente era vuoto.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Il campo Password era vuoto.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // crea una connessione al database, utilizzando le costanti da config/db.php (che abbiamo caricato in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // cambia il set di caratteri in utf8 e controlla
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // se non ci sono errori di connessione (= connessione al database funzionante)
            if (!$this->db_connection->connect_errno) {

                // esegue l'escape dei dati POST
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);

                // query al database, ottenendo tutte le informazioni dell'utente selezionato (consente l'accesso tramite indirizzo email nel campo username)
                $sql = "SELECT user_name, user_email, user_password_hash
                        FROM users
                        WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);

                // se questo utente esiste
                if ($result_of_login_check->num_rows == 1) {

                    // ottieni la riga di risultato (come un oggetto)
                    $result_row = $result_of_login_check->fetch_object();

                    // utilizzando la funzione password_verify() di PHP 5.5 per verificare se la password fornita corrisponde all'hash della password di quell'utente
                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {

                        // scrivi i dati dell'utente nella SESSION di PHP (un file sul tuo server)
                        $_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_email'] = $result_row->user_email;
                        $_SESSION['user_login_status'] = 1;

                    } else {
                        $this->errors[] = "Password errata. Riprova.";
                    }
                } else {
                    $this->errors[] = "Questo utente non esiste.";
                }
            } else {
                $this->errors[] = "Problema di connessione al database.";
            }
        }
    }

    /**
     * esegue il logout
     */
    public function doLogout()
    {
        // elimina la sessione dell'utente
        $_SESSION = array();
        session_destroy();
        // restituisce un piccolo messaggio di feedback
        $this->messages[] = "Hai effettuato il logout.";

    }

    /**
     * semplicemente restituisce lo stato attuale dell'accesso dell'utente
     * @return boolean stato di accesso dell'utente
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // valore di default di ritorno
        return false;
    }
}
?>
