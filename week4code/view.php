<?php
session_start();
require_once "pdo.php"; 

if (!isset($_SESSION['name'])){
    die("Not logged in");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Yogesh Bavishi's Autos database</title>
        <?php 
            require_once "bootstrap.php";  
        ?>
    </head>
    <body>
        <div class="container">
        <h1>Tracking Autos for <?php echo $_SESSION['name'];?></h1>
        <?php
            if ( isset($_SESSION['added']) ){
                echo('<p style="color: green;">Record inserted</p><br/>');
                unset($_SESSION['added']);
            }
        ?>
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
        <p>
                <a href="add.php"> Add New</a> | <a href="logout.php">Logout</a>
        </p>

        </div>      
    </body>
</html>