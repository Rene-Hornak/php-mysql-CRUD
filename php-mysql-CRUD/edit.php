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
            header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
            return;
        } 
        
        // Error message year must be an integer and redirect back to this page
        if (!is_numeric($_POST['year'])) {
            $_SESSION['error']= "Year must be an integer";
            header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
            return;
        }
        
        // Error message mileage must be an integer and redirect back to this page
        if (!is_numeric($_POST['mileage'])) { 
            $_SESSION['error']= "Mileage must be an integer";
            header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
            return;

        } 

        // Update values into database
        $sql = "UPDATE autos SET make = :make, 
                model = :model, year = :year, mileage = :mileage 
                WHERE autos_id = :autos_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage'],
            ':autos_id' => $_POST['autos_id']
            )
        );
                
        // Add success flash message to SESSION and redirect back to index.php
        $_SESSION['success'] = "Record edited"; 
        header("Location: index.php");
        return; 
    }

    // Based on ID find correct information
    $stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id = :autos_id");
    $stmt->execute(array(":autos_id" => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ( $row === false ) {
        $_SESSION['error'] = "Bad value for autos_id";
        header("Location: index.php");
        return; 
    }

    // Make variables to show old input
    $make = htmlentities($row['make']);
    $model = htmlentities($row['model']);
    $year = htmlentities($row['year']);
    $mileage = htmlentities($row['mileage']);
    $autos_id = $row['autos_id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Automobile Tracker</title>
</head>
<body>
    <h1>Editing Automobile</h1>
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
        <input type="text" name="make" id="makeID" value="<?= $make ?>"><br/>

        <label for="modelID">Model</label>
        <input type="text" name="model" id="modelID" value="<?= $model ?>"><br/>
        
        <label for="yearID">Year</label>
        <input type="text" name="year" id="yearID" value="<?= $year ?>"><br/>

        <label for="mileageID">Mileage</label>
        <input type="text" name="mileage" id="mileageID" value="<?= $mileage ?>"><br/>

        <input type="hidden" name="autos_id" value="<?= $autos_id ?>"><br/>
        
        <input type="submit" value="Save">
        <a href="index.php">Cancel</a> 
    </form>
</body>
</html>
