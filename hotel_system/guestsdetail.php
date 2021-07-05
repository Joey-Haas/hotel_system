<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.html');
	exit;
}

// Check existence of idGuest parameter before processing further
if(isset($_GET["idGuest"]) && !empty(trim($_GET["idGuest"]))){
    
include 'config/db.php';
    
    // Prepare a select statement
    $sql = "SELECT * FROM checked_in WHERE idGuest = ?";
    
    if($stmt = mysqli_prepare($con, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_idGuest);
        
        // Set parameters
        $param_idGuest = trim($_GET["idGuest"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individGuestual field value
                $sFirstname = $row["sFirstname"];
                $sLastname = $row["sLastname"];
                $sAddress = $row["sAddress"];
                $iPhonenumber = $row["sPhone"];
                $sMail = $row["sMail"];
                $sCheck_in = $row["dCheck_in"];
                $sCheck_out = $row["dCheck_out"];
                $hotel_rooms_idRoom = $row["hotel_rooms_idRoom"];
            } else{
                // URL doesn't contain validGuest idGuest parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($con);
} else{
    // URL doesn't contain idGuest parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design/layout.css">
    <link rel="stylesheet" href="design/detail.css">
    <title>Details</title>
</head>
<body>
    <div class="header">
        <nav class="navbar">
            <!-- Weergeven van de aangemelde gebruiker. -->
            <p>Hello, <a href="profile.php"><?=$_SESSION['name']?></a></p>
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php" class="nav-link">agenda</a></li>
                <li class="nav-item"><a href="search.php" class="nav-link">search</a></li>
                <li class="nav-item"><a href="checkin.php" class="nav-link">check-in</a></li>
                <!-- Account link alleen weergeven als de admin is aangemeld. -->
                <?php if ($_SESSION['employee_type_idEmployeetype'] == 1) {
                    echo '<li class="nav-item"><a href="account.php" class="nav-link">accounts</a></li>';
                    }
                ?>
                <li class="nav-item"><a href="logout.php" class="nav-link">logout</a></li>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </div>

    <div class="parent">
        <div class="box">
            <!-- Specifieke informatie over een gast. -->
            <h1 class="title">Details</h1>
            <div>
                <label class="subtitle">First name</label>
                <p class="value"><?php echo $row["sFirstname"]; ?></p>
            </div>

            <div>
                <label class="subtitle">Last name</label>
                <p class="value"><?php echo $row["sLastname"]; ?></p>
            </div>

            <div>
                <label class="subtitle">Address</label>
                <p class="value"><?php echo $row["sAddress"]; ?></p>
            </div>

            <div>
                <label class="subtitle">Phone number</label>
                <p class="value"><?php echo $row["sPhone"]; ?></p>
            </div>

            <div>
                <label class="subtitle">Email address</label>
                <p class="value"><?php echo $row["sMail"]; ?></p>
            </div>

            <div>
                <label class="subtitle">Check-in date</label>
                <p class="value"><?php echo $row["dCheck_in"]; ?></p>
            </div>

            <div>
                <label class="subtitle">Check-out date</label>
                <p class="value"><?php echo $row["dCheck_out"]; ?></p>
            </div>

            <div>
                <label class="subtitle">Room number</label>
                <p class="value"><?php echo $row["hotel_rooms_idRoom"]; ?></p>
            </div>

            <!-- delete and backwards buttons below guest details. -->
            <div class="buttons">
                <?php 
                            echo '<a href="updateguest.php?idGuest='. $row['idGuest'] .'" class="btn" id="update">update</a>';
                            echo '<a href="checkout.php?idGuest='. $row['idGuest'] .'" class="btn">leaves</a>';
                        ?>
                <!-- <a href="guests.php" class="backbtn">back</a> -->
            </div>
        </div>
    </div>


    <script src="javascript/script.js"></script>

</body>
</html>