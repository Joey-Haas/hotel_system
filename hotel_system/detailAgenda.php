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
    <link rel="stylesheet" href="design/detailAgenda.css">
    <title>agenda</title>
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

    <div class="center">
        <div class="content">
            <h3 class="title">Following guests will be checking-out today</h3>
            <div class="results">
        <?php
                $date_sql = date("Y-m-d", strtotime($_GET['datum'])); 
                $sql = "SELECT * FROM checked_in where dCheck_out = '$date_sql'";
                $result = mysqli_query($con, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // OUTPUT DATE OF EACH ROW
                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        echo $row['sFirstname'] . ' ' . $row['sLastname'] . ' ' . 'checks-out and room' . ' ' . $row['hotel_rooms_idRoom'] . ' ' . 'will become available again.'; 
                    }
                }
                else {
                    echo 'No one checks-out today';
                }
        ?>
            </div>
        </div>
    </div>

    <script src="javascript/script.js"></script>
    
</body>
</html>