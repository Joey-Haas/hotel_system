<?php
include 'config/db.php';

// Check of de form data gesubmit is. isset() zorgt daarvoor.
if (!isset($_POST['sFirstname'], $_POST['sLastname'], $_POST['sUsername'], $_POST['sPassword'], $_POST['sMail'])) {
    // Niet alle data is ingevoerd. Kan dus ook niet verwerkt worden.
	exit('Please complete the registration form!');
}
// Check of de registratie values die gesubmit zijn niet leeg worden verstuurd.
if (empty($_POST['sFirstname']) || empty($_POST['sLastname']) || empty($_POST['sUsername']) || empty($_POST['sPassword']) || empty($_POST['sMail'])) {
	// Als er één of meer lege values zijn.
	exit('Please complete the registration form');
}

// Checken of er al een account met dezelfde username bestaat.
if ($stmt = $con->prepare('SELECT idEmployee, sPassword FROM employees WHERE sUsername = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hashen van het password dmv PHP password_hash function.
	$stmt->bind_param('s', $_POST['sUsername']);
	$stmt->execute();
	$stmt->store_result();
	// Opslaan van de resultaten zodat je kan checken of het account in de database staat.
	if ($stmt->num_rows > 0) {
		// Username bestaat al in de database.
		echo 'Username exists, please choose another!';
	} else {
		// Username bestaat nog niet, nieuw account wordt in de database geplaatst.
if ($stmt = $con->prepare('INSERT INTO employees (sFirstname, sLastname, sUsername, sPassword, sMail) VALUES (?, ?, ?, ?, ?)')) {
	// Passwords willen we niet blootleggen in de database. Deze worden dus gehashed, en tijdens login maak ik gebruik
	// van een password_verify.
	$password = password_hash($_POST['sPassword'], PASSWORD_DEFAULT);
	$stmt->bind_param('sssss', $_POST['sFirstname'], $_POST['sLastname'], $_POST['sUsername'], $password, $_POST['sMail']);
	$stmt->execute();

	// echo 'Account succesfully registered';
	echo '<b>Account succesfully registered ...<br><br>
                    </b>
                    <meta http-equiv="refresh" content="2; url=\'account.php\'">';
} else {
	// Er klopt iets niet aan het sql statement, check of de users table bestaat met alle 3 de velden.
	echo 'Could not prepare statement!';
}
	}
	$stmt->close();
} else {
	// Er klopt iets niet aan het sql statement, check of de users table bestaat met alle 3 de velden.
	echo 'Could not prepare statement!';
}
$con->close();
?>