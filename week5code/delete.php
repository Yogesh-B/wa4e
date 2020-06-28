<?php
session_start();
if(!isset($_SESSION['name'])){
    die("ACCESS DENIED");
}
require_once "pdo.php";

if ( !isset($_GET['autos_id']) ){  //if there is no get value given
  $_SESSION['error'] = "Bad value for id";
  header("Location: index.php");
  return;
}

require_once "pdo.php";

$get1 = $_GET['autos_id'];
$fetch_query = $pdo->prepare("SELECT * FROM autos WHERE autos_id=$get1");
$fetch_query->execute();
$row1 = $fetch_query->fetch(PDO::FETCH_ASSOC);
if( $fetch_query->rowCount() === 0 ){
  $_SESSION['error'] = "Bad value for id";
  header("Location: index.php");
  return;
}



if ( isset($_POST['delete']) ) {
        $send_query = $pdo->prepare("DELETE FROM AUTOS WHERE autos_id=$get1");
        $send_query->execute();
        $_SESSION['success'] = "Record deleted";
        header("Location: index.php");
        return;      
}


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Yogesh Bavishi's Editing page</title>
        <?php require_once "bootstrap.php";?>
    </head>
    <body>
        <div class="container">
            <h3>Confirm: Deleting <?php echo $row1['make']?></h3>
            <form method="POST">
               <input type="submit" name="delete" value="Delete">
               <a href="index.php">Cancel</a>
            </form>
        </div>
    </body>
</html>
