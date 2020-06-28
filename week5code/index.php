<?php
require_once "pdo.php";
session_start();

$stmt = $pdo->prepare("SELECT * FROM autos");
$stmt->execute();

?>
<html>
    <head>
        <title>Yogesh Bavishi's Autos</title>
        <?php require_once "bootstrap.php";?>
    </head>
    <body>
        <div class="container">
            <h1>Welcome to the Automobiles Database</h1>
            <?php if(!isset($_SESSION['name'])){  //Shows Login request as per login status
                echo '<a href="login.php">Please log in</a>';
                echo '<p>Attempt to <a href="add.php">add data</a> without logging in</p>';
                }
                
        
            else {
                if ( isset($_SESSION['success']) ){
                    echo '<p style="color:green;">'.$_SESSION['success'].'</p>';
                    unset($_SESSION['success']);
                }
                if ( isset($_SESSION['error']) ){
                    echo '<p style="color:red;">'.$_SESSION['error'].'</p>';
                    unset($_SESSION['error']);
                }
                if ( $stmt->rowCount() === 0 ){
                    echo "<p>No rows found</p>";  //there is no data in DB
                }
                else{
                echo '<table border="1px" cellpadding="5px">';
                echo '<thead><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></thead>'; // <!--shows table from database -->
                
                while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
                    echo "<tr>";
                    echo "<td>".$row['make']."</td>";
                    echo "<td>".$row['model']."</td>";
                    echo "<td>".$row['year']."</td>";
                    echo "<td>".$row['mileage']."</td>";
                    echo '<td><a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a>/<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a></td>';
                    echo "</tr>";                
                }
                
                echo '</table>';
                }
                
            echo '<p><a href="add.php">Add New Entry</a></p>';
            echo '<p><a href="logout.php">Logout</a></p>';
           
            }?>    
        </div>
    </body>
</html>