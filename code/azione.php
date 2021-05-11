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
    .contenitore{
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        margin-top: 100px;
    }
</style>

<body class="w3-sand contenitore">

    <a style="margin-top:30px;border:1px solid black;" type="button" class="w3-button" href="prenota.php">Prenota</a>
    <a style="margin-top:30px;border:1px solid black;" type="button" class="w3-button" href="index.php">Ritorna Alla Home</a>
    <a style="margin-top:30px;border:1px solid black;" type="button" class="w3-button" href="logout.php">Logout</a>

<?php

    require("functions.php");
    if(isset($_SESSION["emailUtente"]) && checkIfAdmin($_SESSION["emailUtente"])){
        echo '<a style="margin-top:30px;border:1px solid black;" type="button" class="w3-button" href="adminPanel.php">Amministra</a>';
    }

?>
</body>

</html>