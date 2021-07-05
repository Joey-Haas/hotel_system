<?php
session_start();
include 'config/db.php';

// Check of de form data gesubmit is. isset() zorgt daarvoor.
if ( !isset($_POST['sUsername'], $_POST['sPassword']) ) {
    // Niet alle data is ingevoerd. Kan dus ook niet verwerkt worden.
	exit('Please fill both the username and password fields!');
}

// Prepare SQL, preparing van het SQL statement voorkomt SQL injections.
if ($stmt = $con->prepare('SELECT idEmployee, employee_type_idEmployeetype, sPassword FROM employees WHERE sUsername = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in dit geval is de gebruikersnaam een string.
    // Maak dus gebruik van "s".
	$stmt->bind_param('s', $_POST['sUsername']);
	$stmt->execute();
    // Opslaan van de resultaten, daardoor kan gecheckt worden of het account
    // aanwezig is in de database.
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($idEmployee, $employee_type_idEmployeetype, $password);
        $stmt->fetch();
        // Account is aanwezig, Vervolgens wordt het wachtwoord geverifieërd.

        // Notitie: Herinner het gebruik van password_hash in het registratie bestand (register.php). 
        // Wachtwoorden moeten gehashed opgeslagen worden.
        if (password_verify($_POST['sPassword'], $password)) {
            // Verificatie succesvol, gebruiker is aangemeld.

            // Aanmaken van sessions. Zo weten we of de gebruiker is ingelogd. Gedraagd zich als een cookie, 
            // maar herinnert de data op de server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['sUsername'];
            $_SESSION['idEmployee'] = $idEmployee;
            $_SESSION['employee_type_idEmployeetype'] = $employee_type_idEmployeetype;
            header('Location: index.php');
        } else {
            // Foutief wachtwoord.
            echo 'Incorrect username and/or password!';
        }
    } else {
        // Foutief gebruikersnaam
        echo 'Incorrect username and/or password!';
    }
	$stmt->close();
}
?>