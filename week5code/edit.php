<?php
session_start();
if(!isset($_SESSION['name'])){      //not logged in
    die("ACCESS DENIED");
}

if ( isset($_POST['cancel']) ){   //cancel button pressed
    header("Location: index.php");
    return;
}
if ( !isset($_GET['autos_id']) ){  //if there is no get value given
    $_SESSION['error'] = "Bad value for id";
    header("Location: index.php");
    return;
}

require_once "pdo.php";

$get1 = $_GET['autos_id'];        //values not matching of GET and database autos_id
$fetch_query = $pdo->prepare("SELECT * FROM autos WHERE autos_id=$get1");
$fetch_query->execute();
$row1 = $fetch_query->fetch(PDO::FETCH_ASSOC);
if( $fetch_query->rowCount() === 0 ){
    $_SESSION['error'] = "Bad value for id";
    header("Location: index.php");
    return;
 }

if ( isset($_POST['add']) ) {  //updates data
        
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['mileage']) < 1 || strlen($_POST['year']) < 1 )
    {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?autos_id=$get1");
        return;        
    }
    else if ( !is_numeric($_POST['year']) ){
        $_SESSION['error'] = "Year must be numeric";
        header("Location: edit.php?autos_id=$get1");
        return;
    }
    else if ( !is_numeric($_POST['mileage']) ){
        $_SESSION['error'] = "Mileage must be numeric";
        header("Location: edit.php?autos_id=$get1");
        return;
    }
    else {
        $send_query = $pdo->prepare("UPDATE autos SET make= :mk, model= :md, year= :yr, mileage= :mi  WHERE autos_id=$get1");
        $send_query->execute(array(
            ':mk'=>$_POST['make'],
            ':md'=>$_POST['model'],
            ':yr'=>$_POST['year'],
            ':mi'=>$_POST['mileage']
            ));
        $_SESSION['success'] = "Record inserted";   //:)
        header("Location: index.php");
        return;  
    }


    
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
            <h1>Editing Automobile</h1>
            <?php 
             $id = htmlentities($row1['autos_id']);
             $make = htmlentities($row1['make']);
             $model = htmlentities($row1['model']);
             $year = $row1['year'];
             $mileage = $row1['mileage'];
             if ( isset($_SESSION['error']) ){
                echo '<p style="color:red;">'.$_SESSION['error'].'</p>';
                unset($_SESSION['error']);
            }
            ?>
            
            <form method="POST">
                <p>Make:
                <input type="text" name="make" size="60" value="<?=$make?>"/></p>
                <p>Model:
                <input type="text" name="model" size="60" value="<?=$model?>"/></p>
                <p>Year:
                <input type="text" name="year" value="<?=$year?>"/></p>
                <p>Mileage:
                <input type="text" name="mileage" value="<?=$mileage?>"/></p>
                <input type="submit" name="add" value="Save">
                <input type="submit" name="cancel" value="Cancel">
            </form>
        </div>
    </body>
</html>
