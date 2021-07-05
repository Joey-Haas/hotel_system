<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.html');
	exit;
}

include 'config/db.php';

if ($_GET['action']=='insert') {
	if (!isset($_POST['sFirstname'], $_POST['sLastname'], $_POST['sAddress'], $_POST['sMail'], $_POST['sPhone'], $_POST['dCheck_in'], $_POST['dCheck_out'], $_POST['hotel_rooms_idRoom'])) {
		// Data die verzonden zou moeten worden is niet beschikbaar, exit.
		exit('Please complete the check-in form!');
	}
	
	// Invoegen van een nieuwe gast.
	if ($stmt = $con->prepare('INSERT INTO checked_in (sFirstname, sLastname, sAddress, sMail, sPhone, dCheck_in, dCheck_out, hotel_rooms_idRoom) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
		$stmt->bind_param('sssssssi', $_POST['sFirstname'], $_POST['sLastname'], $_POST['sAddress'], $_POST['sMail'], $_POST['sPhone'], $_POST['dCheck_in'], $_POST['dCheck_out'], $_POST['hotel_rooms_idRoom']);
		$stmt->execute();
		// Tweede statement wordt uitgevoerd om de kamer op bezet te zetten. Beschikbaar is 1, bezet is 2. 
		// Hierdoor is de kamer niet beschikbaar als deze al toegewezen aan een gast.
		$available = 2;
		$stmt2 = $con->prepare("UPDATE available_rooms_has_hotel_rooms SET available_rooms_idAvailability = ? WHERE hotel_rooms_idRoom = ?");
		$stmt2->bind_param('ii', $available, $_POST['hotel_rooms_idRoom']);
		$stmt2->execute();
		// echo 'check-in succesful.';
		echo '<b>Guest check-in succesful.<br><br>
						</b>
						<meta http-equiv="refresh" content="2; url=\'index.php\'">';
	} else {
		// Er klopt iets niet aan het sql statement. Check of de tabellen inclusief de velden aanwezig zijn.
		echo 'Could not prepare statement!';
	} 
		{
		$stmt->close();
	} 
	$con->close();
}

// Update
if ($_GET['action']=='update') {
	if(isset($_POST['sFirstname'], $_POST['sLastname'], $_POST['sAddress'], $_POST['sPhone'], $_POST['sMail'], $_POST['dCheck_in'], $_POST['dCheck_out'])){
        // Prepare update statement

        $sql = "UPDATE checked_in SET sFirstname=?, sLastname=?, sAddress=?, sPhone=?, sMail=?, dCheck_in=?, dCheck_out=? WHERE idGuest=?";
         
        if($update = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($update, "sssssssi", $param_sFirstname, $param_sLastname, $param_sAddress, $param_sPhone, $param_sMail, $param_dCheck_in, $param_dCheck_out, $param_idGuest);
            
            // Set parameters
            $param_sFirstname = $_POST['sFirstname'];
            $param_sLastname = $_POST['sLastname'];
            $param_sAddress = $_POST['sAddress'];
			$param_sPhone = $_POST['sPhone'];
            $param_sMail = $_POST['sMail'];
			$param_dCheck_in = $_POST['dCheck_in'];
			$param_dCheck_out = $_POST['dCheck_out'];
            $param_idGuest = $_POST['idGuest'];
            
            // probeer het prepared statement uit te voeren
            if(mysqli_stmt_execute($update)){
                // Succesvol geupdate. doorsturen naar de zoek pagina.
                echo '<b>Guest information update succesful.<br><br>
						</b>
						<meta http-equiv="refresh" content="2; url=\'search.php\'">';
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
    // Close connection
    mysqli_close($con);
}
// Ending of update
?>