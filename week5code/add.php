<?php
session_start();
if(!isset($_SESSION['name'])){
    die("ACCESS DENIED");
}
require_once "pdo.php";

if ( isset($_POST['cancel']) ){
    header("Location: index.php");
    return;
}


if ( isset($_POST['add']) ) {
        
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['mileage']) < 1 || strlen($_POST['year']) < 1 )
    {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;        
    }
    else if ( !is_numeric($_POST['year']) ){
        $_SESSION['error'] = "Year must be numeric";
        header("Location: add.php");
        return;
    }
    else if ( !is_numeric($_POST['mileage']) ){
        $_SESSION['error'] = "Mileage must be numeric";
        header("Location: add.php");
        return;
    }
    else {
        $send_query = $pdo->prepare("INSERT INTO autos ( make, model, year, mileage ) VALUES (:mk, :md, :yr,:mi)");
        $send_query->execute(array(
            ':mk'=>$_POST['make'],
            ':md'=>$_POST['model'],
            ':yr'=>$_POST['year'],
            ':mi'=>$_POST['mileage']
            ));
        $_SESSION['success'] = "Record added";
        header("Location: index.php");
        return;  
    }
    
}


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Yogesh Bavishi's Adding page</title>
        <?php require_once "bootstrap.php";?>
    </head>
    <body>
        <div class="container">
            <h1>Tracking Automobiles for <?php echo htmlentities($_SESSION['name'])?></h1>
            <?php
                // Flash pattern
                if ( isset($_SESSION['error']) ) {
                    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
                    unset($_SESSION['error']);
                }
            ?>
            <form method="POST">
                <p>Make:
                <input type="text" name="make" size="60"/></p>
                <p>Model:
                <input type="text" name="model" size="60"/></p>
                <p>Year:
                <input type="text" name="year"/></p>
                <p>Mileage:
                <input type="text" name="mileage"/></p>
                <input type="submit" name="add" value="Add">
                <input type="submit" name="cancel" value="Cancel">
            </form>
        </div>
    </body>
</html>
