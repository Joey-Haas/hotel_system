<?php
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.html');
        exit;
    }

    // Ophalen van idGuest die doorgestuurd is vanuit de detail pagina.
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
                    $sPhone = $row["sPhone"];
                    $sMail = $row["sMail"];
                    $dCheck_in = $row["dCheck_in"];
                    $dCheck_out = $row["dCheck_out"];
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
    <link rel="stylesheet" href="design/checkin.css">
    <title>Update</title>
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

    <div class="container">
        <form action="guestfunc.php?action=update" method="post">
            <div class="text">
                <p>Update guest information</p>
            </div>
            <input type="hidden" name="idGuest" value='<?php echo $_GET["idGuest"]; ?>'>
            <div class="row">
                <div class="col-25">
                    <label for="sFirstname">First name</label>
                </div>
                <div class="col-75">
                    <input type="text" name="sFirstname" value="<?php echo $sFirstname; ?>" placeholder="First name"
                        required>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="sLastname">Last name</label>
                </div>
                <div class="col-75">
                    <input type="text" name="sLastname" value="<?php echo $sLastname; ?>" placeholder="Last name"
                        required>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="sAddress">Address</label>
                </div>
                <div class="col-75">
                    <input type="text" name="sAddress" value="<?php echo $sAddress; ?>" placeholder="Address" required>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="sPhone">Phone number</label>
                </div>
                <div class="col-75">
                    <input type="text" name="sPhone" value="<?php echo $sPhone; ?>" placeholder="Phone number" required>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="sMail">eMail</label>
                </div>
                <div class="col-75">
                    <input type="email" name="sMail" value="<?php echo $sMail; ?>" placeholder="eMail" required>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="dCheck_in">Check-in date</label>
                </div>
                <div class="col-75">
                    <input type="date" name="dCheck_in" value="<?php echo $dCheck_in; ?>" placeholder="dCheck_in"
                        required>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="dCheck_out">Check-out date</label>
                </div>
                <div class="col-75">
                    <input type="date" name="dCheck_out" value="<?php echo $dCheck_out; ?>" placeholder="checks-out"
                        required>
                </div>
            </div>

            <div class="row">
                <input type="submit" class="btn btn-primary" value="Save">
            </div>
        </form>
    </div>

    <script src="javascript/script.js"></script>

</body>
</html>