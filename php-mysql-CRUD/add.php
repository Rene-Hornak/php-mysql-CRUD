<?php
    require_once "pdo.php";
    session_start();

    // If user is not logged in denied his/her access
    if ( ! isset($_SESSION['email'])) {
        die("ACCESS DENIED");
    }

    // Check to see if we have some POST data, if we do process it
    if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {

        // Error message all fields are required and redirect back to this page
        if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || 
        strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
            $_SESSION['error'] = "All fields are required";
            header("Location: add.php");
            return;
        } 
        
        // Error message year must be an integer and redirect back to this page
        if (!is_numeric($_POST['year'])) {
            $_SESSION['error']= "Year must be an integer";
            header("Location: add.php");
            return;
        }  
        
        // Error message mileage must be an integer and redirect back to this page
        if (!is_numeric($_POST['mileage'])) { 
            $_SESSION['error']= "Mileage must be an integer";
            header("Location: add.php");
            return;
        } 

        // Insert values into database
        $sql = "INSERT INTO autos (make, model, year, mileage) 
                VALUES ( :make, :model, :year, :mileage)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage']
            )
        );
                
        // Add success flash message to SESSION and redirect back to index.php
        $_SESSION['success'] = "Record added"; 
        header("Location: index.php");
        return;       
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Automobile Tracker</title>
</head>
<body>
    <h1>Tacking Automobiles</h1>
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
    ?>
    <form method="post">
        <label for="makeID">Make</label>
        <input type="text" name="make" id="makeID"><br/>

        <label for="modelID">Model</label>
        <input type="text" name="model" id="modelID"><br/>
        
        <label for="yearID">Year</label>
        <input type="text" name="year" id="yearID"><br/>

        <label for="mileageID">Mileage</label>
        <input type="text" name="mileage" id="mileageID"><br/>
        
        <input type="submit" value="Add">
        <a href="index.php">Cancel</a> 
    </form>
</body>
</html>
