<?php
    session_start();
    
    // Redirect the browser to index.php
    if ( isset($_POST['cancel'] ) ) {
        header("Location: index.php");
        return;
    }

    // Check to see if we have some POST data, if we do process it
    if ( isset($_POST['email']) && isset($_POST['pass']) ) {
        unset($_SESSION['email']); // Logout current user

        // Error checking is email and pass empty?
        if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
            $_SESSION['error'] = "Email and password are required";
            header("Location: login.php");
            return;
        } 
        
        // Error checking email contains @
        if (strpos($_POST['email'], '@') === FALSE ) {
            $_SESSION['error'] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        } 
        
        // Error checking email is correct
        if ($_POST['email'] !== 'umsi@umich.edu'){
            $_SESSION['error'] = "Incorect email";
            header("Location: login.php");
            return;
        } 
        
        // Error checking pass is incorrect
        if ($_POST['pass'] !== 'php123') {
            $_SESSION['error'] = "Incorrect password";

            error_log("Login fail " . $_POST['email'] . " $check");
            header("Location: login.php");
            return;
        }

        // Error checking pass is correct
        if ($_POST['pass'] == 'php123') {
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['success'] = "Logged in";

            error_log("Login success " . $_POST['email']);
            header('Location: index.php');
            return;
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Automobile Tracker</title>
    </head>
    <body>
        <h1>Please Log In</h1>
        <?php
            // Flash messages for error
            if (isset($_SESSION['error'])) {
                echo("<p style=\"color: red;\">" . $_SESSION['error'] . "</p>\n");
                unset($_SESSION['error']);
            }
        ?>
        <form method="post">
            <label for="name">User Name</label>
            <input type="text" name="email" id="name"/><br/>

            <label for="password">Password</label>
            <input type="text" name="pass" id="password"/><br/>
            
            <input type="submit" value="Log In">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </body>
</html>
