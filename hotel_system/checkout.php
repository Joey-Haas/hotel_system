<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.html');
	exit;
}

include 'config/db.php';

// delete guest

if(isset($_POST["idGuest"]) && !empty($_POST["idGuest"])){
        $stmt = $con->prepare('SELECT hotel_rooms_idRoom FROM checked_in WHERE idGuest = ?');
		$stmt->bind_param('i', $_POST['idGuest']);
		$stmt->execute();

        $stmt->bind_result($idRoom);
        $stmt->fetch();

        $stmt->close();

        $update = $con->prepare("UPDATE available_rooms_has_hotel_rooms SET available_rooms_idAvailability = 1 WHERE hotel_rooms_idRoom = ?");
        $update->bind_param('i', $idRoom);
        $update->execute();

		$stmt3 = $con->prepare("DELETE FROM checked_in WHERE idGuest = ?");
		$stmt3->bind_param('i', $_POST['idGuest']);
		$stmt3->execute();

        header("location: search.php");
		// echo 'check-in succesful.';
		// echo '<b>Guest check-in succesful.<br><br>
		// 	  </b>
		// 	  <meta http-equiv="refresh" content="2; url=\'index.php\'">';
	}
 else{
    // Check existence of idGuest parameter
    if(empty(trim($_GET["idGuest"]))){
        // URL doesn't contain idGuest parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="design/checkout.css">
    <link rel="stylesheet" href="design/layout.css">
</head>
<body>
    <div class="parent">
        <section class="top">
            <div class="login">
                <h2 class="title">Check-out the following guest</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger">
                        <div class="deleteid">
                            <?php echo trim($_GET["idGuest"]); ?>
                        </div>

                        <!-- Displays text and delete or cancel buttons. -->
                        <div class="buttons">
                            <!-- hidden input type must be here to delete -->
                            <input type="hidden" name="idGuest" value="<?php echo trim($_GET["idGuest"]); ?>">
                            <p>Please make sure.</p>
                            <button type="submit" value="delete" class="btn">check-out</button>
                            <a href="search.php" class="btn" id="cancel">cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <script src="javascript/script.js"></script>

</body>
</html>