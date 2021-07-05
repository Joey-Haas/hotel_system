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
    <link rel="stylesheet" href="design/searchdetail.css">
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

    <div class="searchresult">
        <div class="box">
            <?php
                echo '<table class="result-table">';
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Guest ID</th>";
                    echo "<th>first name</th>";
                    echo "<th>last name</th>";
                    echo "<th>room number</th>";
                    echo "<th>action</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    if (isset($_POST['submit-search'])) {
                        $search = mysqli_real_escape_string($con, $_POST['search']);
                        $sql = "SELECT * FROM checked_in WHERE sFirstname LIKE '%$search%' OR sLastname LIKE '%$search%' OR sMail LIKE '%$search%'";
                        $result = mysqli_query($con, $sql);
                        $queryResult = mysqli_num_rows($result);

                        // echo "There are ".$queryResult." results!";

                        if ($queryResult > 0) {
                            echo "".$queryResult." result(s) matched your search!";

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                            echo "<td>" . $row['idGuest'] . "</td>";
                                            echo "<td>" . $row['sFirstname'] . "</td>";
                                            echo "<td>" . $row['sLastname'] . "</td>";
                                            echo "<td>" . $row['hotel_rooms_idRoom'] . "</td>";
                                            echo "<td>";
                                                echo '<a href="guestsdetail.php?idGuest='. $row['idGuest'] .'" class="view">view</a>';
                                            echo "</td>";
                                        echo "</tr>";
                            }
                        } else {
                            echo "There are no results matching your search!";
                        }
                    }
                    mysqli_close($con);
                ?>
        </div>
    </div>

    <script src="javascript/script.js"></script>

</body>
</html>