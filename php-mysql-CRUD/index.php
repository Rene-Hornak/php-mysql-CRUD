<?php
    require_once "pdo.php";
    session_start();

    $sql = "SELECT make, model, year, mileage, autos_id FROM autos ORDER BY make";
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC)
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Automobile Tracker</title>
    </head>
    <body>
        <?php
            // Flash messages for error and success
            if (isset($_SESSION['error'])) {
                echo("<p style=\"color: red;\">" . $_SESSION['error'] . "</p>\n");
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo("<p style=\"color: green;\">" . $_SESSION['success'] . "</p>\n");
                unset($_SESSION['success']);
            }

            // If user is logged in
            if(isset($_SESSION['email'])) {

                // If database is empty
                if(count($rows) === 0) {
                    echo "<p>No rows found</p>";  

                } else {
                    echo '<table border="1">';

                    // Table header
                    echo "<tr><th>Make</th>";
                    echo "<th>Model</th>";
                    echo "<th>Year</th>";
                    echo "<th>Mileage</th>";
                    echo "<th>Action</th></tr>";
                    
                    // Table body, informations from database 
                    foreach($rows as $row) {
                        echo "<tr><td>";
                        echo htmlentities($row['make']);
                        echo "</td><td>";
                        echo htmlentities($row['model']);
                        echo "</td><td>";
                        echo htmlentities($row['year']);
                        echo "</td><td>";
                        echo htmlentities($row['mileage']);
                        echo "</td><td>";
                        echo '<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ';
                        echo '<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>'; 
                        echo "</td></tr>";
                    }
                    echo "</table>";
                }
                echo '<a href="add.php">Add New Entry</a> </br>';
                echo '<a href="logout.php">Logout</a>';

            } else {
                // If user is not logged in    
                echo '<h1>Welcome to the Automobiles Database</h1>';
                echo '<p><a href="login.php">Please log in</a></p>';
                echo '<p>Attempt to go to <a href="add.php">add.php</a> without logging in</p>';
            }    
        ?>
    </body>
</html>