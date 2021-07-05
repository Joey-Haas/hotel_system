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
    <link rel="stylesheet" href="design/checkin.css">
    <title>Document</title>
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
        <form action="guestfunc.php?action=insert" method="post" autocomplete="off">
            <div class="text">
                <p>guest check-in</p>
            </div>

            <!-- Simpele input voor de gast zijn/haar voornaam. -->
            <div class="row">
                <div class="col-25">
                    <label for="sFirstname">First name</label>
                </div>
                <div class="col-75">
                    <input type="text" name="sFirstname" placeholder="Joey" id="sFirstname" required>
                </div>
            </div>

            <!-- Simpele input voor de gast zijn/haar achternaam. -->
            <div class="row">
                <div class="col-25">
                    <label for="sLastname">Last name</label>
                </div>
                <div class="col-75">
                    <input type="text" name="sLastname" placeholder="Haas" id="sLastname" required>
                </div>
            </div>

            <!-- Simpele input voor de gast zijn/haar adres. -->
            <div class="row">
                <div class="col-25">
                    <label for="sAddress">Address</label>
                </div>
                <div class="col-75">
                    <input type="text" name="sAddress" placeholder="Street + housenumber" id="sAddress" required>
                </div>
            </div>

            <!-- Simpele input voor de gast zijn/haar emailadres. -->
            <div class="row">
                <div class="col-25">
                    <label for="sEmail">Email</label>
                </div>
                <div class="col-75">
                    <input type="email" name="sMail" placeholder="example@gmail.com" id="sMail" required>
                </div>
            </div>

            <!-- Simpele input voor de gast zijn/haar telefoonnummer. -->
            <div class="row">
                <div class="col-25">
                    <label for="sPhone">Phone number</label>
                </div>
                <div class="col-75">
                    <input type="text" name="sPhone" placeholder="06 123456789" id="sPhone" required>
                </div>
            </div>

            <!-- Net als de check-in date, moet deze als string verstuurd worden naar de database.
                 Vervolgens gaat deze weergegeven worden in de agenda. -->
            <div class="row">
                <div class="col-25">
                    <label for="dCheck_in">Check-in date</label>
                </div>
                <div class="col-75">
                    <input type="date" name="dCheck_in" placeholder="guest arrives" id="dCheck_in" required>
                </div>
            </div>

            <!-- Net als de check-in date, moet deze als string verstuurd worden naar de database.
                 Vervolgens gaat deze weergegeven worden in de agenda. -->
            <div class="row">
                <div class="col-25">
                    <label for="dCheck_out">Check-out date</label>
                </div>
                <div class="col-75">
                    <input type="date" name="dCheck_out" placeholder="guest leaves" id="dCheck_out" required>
                </div>
            </div>

            <!-- Kamers worden alleen met PHP weergeven als deze beschikbaar zijn. 
                 Beschikbare kamers staan in de database als '1'. Is een kamer bezet?
                 Deze zal dan op 0 staan, en is niet beschikbaar tot de gast is uitgecheckt. -->
            <div class="row">
                <div class="col-25">
                    <label for="hotel_rooms_idRoom">Room</label>
                </div>
                <div class="col-75">
                    <?php 
                        // Query voor het weergeven van alle kamers (hotel_rooms_idRoom), met beschikbaarheid (available_rooms_idAvailability=1).
                        // availability 2 (bezet) gaat onderaan in de database staan en wordt niet weergeven.
                        // Zodra deze weer op 1 (beschikbaar) komt te staan, zal deze weer op de originele plek in de database komen.
                        $sql = "SELECT hotel_rooms_idRoom FROM available_rooms_has_hotel_rooms WHERE available_rooms_idAvailability=1";
                        $result = mysqli_query($con, $sql);

                        echo '<select name="hotel_rooms_idRoom" id="hotel_rooms_idRoom">';
                        // fetch object
                        while ($row = mysqli_fetch_array($result)) {
                            // row get hotel room
                            echo "<option value='" . $row['hotel_rooms_idRoom'] . "'>" . $row['hotel_rooms_idRoom'] . "</option>";
                        }

                        echo '</select>';
                    ?>
                </div>
            </div>

            <div class="row">
                <input type="submit" value="check-in">
            </div>
        </form>
    </div>

    <script src="javascript/script.js"></script>

</body>
</html>