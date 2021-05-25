<?php

    session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <title>Coffee And Games - Login</title>
</head>

<style>
    .flexbox{
        display: flex; 
        flex-direction: row; 
        align-items: center;
    }
    .contenitore{
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        margin-top: 100px;
    }
</style>

<body class="w3-sand">

    <header class="flexbox" style="justify-content: space-between;">
        <div class="flexbox">
            <h3 style="margin-left: 10px;">
                Coffee And Games - Valdagno |
            </h3>
            <div class="w3-padding">
                Per momenti fantastici, Insieme
            </div>
        </div>

        <div>
            
        <?php
            require("functions.php");
            if((isset($_SESSION["emailUtente"]))){
                if((time() - $_SESSION["sessionTime"]) < 3600){
                    $righe = getLoginSessionInfo($_SESSION["emailUtente"]);
                    echo '<p style="margin-right: 20px;">Benvenuto, <strong>'.$righe[0]." ".$righe[1].'</strong>';
                }
                else{                   
                    session_destroy();
                }
            }
            else{
                echo "Non sei Loggato";
            }
        ?>
            
        </div>
        
    </header>
    <hr style="border: 1px solid black;">
    <div class="contenitore"> 
        <a style="margin-top:30px;border:1px solid black;" type="button" class="w3-button" href="prenota.php">Prenota</a>
        <a style="margin-top:30px;border:1px solid black;" type="button" class="w3-button" href="index.php">Ritorna Alla Home</a>
        <a style="margin-top:30px;border:1px solid black;" type="button" class="w3-button" href="logout.php">Logout</a>
    

<?php

    if(isset($_SESSION["emailUtente"]) && checkIfAdmin($_SESSION["emailUtente"])){
        echo '<a style="margin-top:30px;border:1px solid black;" type="button" class="w3-button" href="adminPanel.php">Amministra</a>';
    }

?>
    </div>
</body>

</html>