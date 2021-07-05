<?php
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.html');
        exit;
    }

    include 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design/layout.css">
    <link rel="stylesheet" href="design/register.css">
    <title>Create employee</title>
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
        <!-- Register.php handelt het aanmaken van een account af. -->
        <form action="registeremp.php" method="post" autocomplete="off">
            <div class="text">
                <p>Create employee account</p>
            </div>

            <!-- Simpele input voor de werknemer zijn/haar voornaam. -->
            <div class="row">
                <div class="col-25">
                    <label for="">First name</label>
                </div>
                <div class="col-75">
                    <input type="text" name="sFirstname" placeholder="Joey" id="sFirstname" required>
                </div>
            </div>

            <!-- Simpele input voor de werknemer zijn/haar achternaam. -->
            <div class="row">
                <div class="col-25">
                    <label for="">Last name</label>
                </div>
                <div class="col-75">
                    <input type="text" name="sLastname" placeholder="Haas" id="sLastname" required>
                </div>
            </div>

            <!-- Simpele input voor de werknemer zijn/haar gebruikersnaam. -->
            <div class="row">
                <div class="col-25">
                    <label for="">Username</label>
                </div>
                <div class="col-75">
                    <input type="text" name="sUsername" placeholder="firstname_reception" id="sUsername" required>
                </div>
            </div>

            <!-- Simpele input voor de werknemer zijn/haar wachtwoord. -->
            <div class="row">
                <div class="col-25">
                    <label for="">Password</label>
                </div>
                <div class="col-75">
                    <input type="password" name="sPassword" placeholder="password" id="sPassword" required>
                </div>
            </div>

            <!-- Simpele input voor de werknemer zijn/haar emailadres. -->
            <div class="row">
                <div class="col-25">
                    <label for="">Email</label>
                </div>
                <div class="col-75">
                    <input type="email" name="sMail" placeholder="example@gmail.com" id="sMail" required>
                </div>
            </div>

            <div class="row">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>

    <script src="javascript/script.js"></script>

</body>
</html>