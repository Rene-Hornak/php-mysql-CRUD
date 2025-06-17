<?php
    require_once "pdo.php";
    session_start();

    // Check to see if we have some POST data, if we do process it
    if ( isset($_POST['delete']) && isset($_POST['autos_id'])) {
        $sql = "DELETE FROM autos WHERE autos_id = :autos_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':autos_id' => $_POST['autos_id']));
                
        // Add success flash message to SESSION and redirect back to index.php
        $_SESSION['success'] = "Record deleted"; 
        header("Location: index.php");
        return;       
    }

    if ( !isset($_GET['autos_id']) ) {
        $_SESSION['error'] = "Missing autos_id";
        header("Location: index.php");
        return;
    }

    $stmt = $pdo->prepare("SELECT make, autos_id FROM autos WHERE autos_id = :autos_id");
    $stmt->execute(array(":autos_id" => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false) {
        $_SESSION['error'] = "Bad value for autos_id";
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
    <h1>Confirm: Deleting <?= htmlentities($row['make']) ?></h1>
    <form method="post">
        <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>"><br/>
        <input type="submit" name="delete" value="Delete">
        <a href="index.php">Cancel</a> 
    </form>
</body>
</html>
