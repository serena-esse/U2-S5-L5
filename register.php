<?php


// Includi le configurazioni / costanti per la connessione al database
require_once("config/db.php");

// Carica la classe di registrazione
require_once("classes/Registration.php");

// Crea l'oggetto di registrazione. Quando questo oggetto viene creato, eseguirà automaticamente tutte le operazioni di registrazione
// quindi questa singola riga gestisce l'intero processo di registrazione.
$registration = new Registration();

// Mostra la vista di registrazione (con il modulo di registrazione e messaggi/errori)
include("views/register.php");
