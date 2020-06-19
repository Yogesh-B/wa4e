<?php
if ( !isset($_GET['name']) )
        die("Name parameter missing");
if ( isset($_POST['logout']) )
        header("location: index.php");
$failure = false;
require_once "pdo.php";

    if ( isset($_POST['add']) ) {
        
        if ( strlen($_POST['make']) < 1 )
        {
            $failure = "Make is required";
        }
        else if ( !is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ){
            $failure = "Mileage and year must be numeric";
        }
        else {
            $send_query = $pdo->prepare("INSERT INTO autos ( make, year, mileage ) VALUES (:mk,:yr,:mi)");
            $send_query->execute(array(
                ':mk'=>$_POST['make'],
                ':yr'=>$_POST['year'],
                ':mi'=>$_POST['mileage']
                ));
        }
        
   }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Yogesh Bavishi's Automobile Tracker</title>
        <?php require_once "bootstrap.php"; ?>
</head>
    <body>
        <div class="container">
        <h1>Tracking Autos for <?php echo $_GET['name'];?></h1>
        <?php
        if ( $failure !== false ) {
            // validation of data
            echo('<p style="color: red;">'.htmlentities($failure)."</p><br/>");
        }
        else if( isset($_POST['add']) ){
            echo('<p style="color: green;">Record inserted</p><br/>');
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
            <input type="submit" name="logout" value="Logout">
        </form>
        <h2>Automobiles</h2>
        <p>
            <?php              //list of automobiles from database
                $fetch_query = $pdo->prepare('SELECT * FROM autos');
                $fetch_query->execute();
                while ( $row = $fetch_query->fetch(PDO::FETCH_ASSOC) ) {
                   echo "<li>".$row['year']."  ".htmlentities($row['make'])."/".$row['mileage']."</li>";
                }
            ?>
        </p>
        </div>
    </body>
</html>