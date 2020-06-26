<?php
session_start();
if (!isset($_SESSION['name'])){
    die("Not logged in");
}

require_once "pdo.php";  


if ( isset($_POST['add']) ) {
        
    if ( strlen($_POST['make']) < 1 )
    {
        $_SESSION['error'] = "Make is required";
        header("Location: add.php");
    }
    else if ( !is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ){
        $_SESSION['error'] = "Mileage and year must be numeric";
        header("Location: add.php");
    }
    else {
        $send_query = $pdo->prepare("INSERT INTO autos ( make, year, mileage ) VALUES (:mk,:yr,:mi)");
        $send_query->execute(array(
            ':mk'=>$_POST['make'],
            ':yr'=>$_POST['year'],
            ':mi'=>$_POST['mileage']
            ));
        $_SESSION['added'] = "Record inserted";
        header("Location: view.php");

    }
    
}
if (isset($_POST['cancel'])){
    header("Location: view.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Yogesh Bavishi's Autos</title>
        <?php
            require_once "bootstrap.php";       
        ?>
    </head>
    <body>
        <div class="container">
            <h1>Tracking Autos for <?php echo $_SESSION['name'];?></h1>
            <?php
                if ( isset($_SESSION['error']) ) {
                    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                    unset($_SESSION['error']);
                }
            ?>
        <form method="POST">
            <p>Make:
            <input type="text" name="make" size="60"/></p>
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

