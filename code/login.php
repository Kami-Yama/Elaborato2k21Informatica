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

<?php

    if((isset($_SESSION["sessionTime"]))){
        if((time() - $_SESSION["sessionTime"]) < 3600){
            echo $_SESSION["emailUtente"];
            header("Location: azione.php");
        }
        else{
            session_destroy();
        }
    }

?>

<style>
    .contenitore{
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        margin-top: 100px;
    }
    .contenitore2{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }

</style>

<body class="w3-sand">
    <div class="contenitore2">
        <div>
        </div>
        <a type="button" style="border:1px solid black;margin-right: 20px;margin-top: 10px;" class="w3-button" href="index.php">Torna alla Home</a>
    </div>
    <hr style="border:1px solid black;"></hr>

    <form action="" method="POST" class="contenitore">
        <label style="margin-top: 100px;" class="w3-label">Email</label>
        <input class="w3-text" type="text" name="email" placeholder="Inserisci la tua Email" style="width:20%;" required>
        <label style="margin-top: 20px;" class="w3-label">Password</label>
        <input type="password" name="password" placeholder="Inserisci la tua Password" style="width:20%" required>
        <input style="margin-top: 15px;border:1px solid black;" type="submit" value="Login" class="w3-button">
        <label class="w3-label" style="font-weight: bold; margin-top: 15px;">Non sei ancora registrato?</label>
        <input style="margin-top: 15px;border:1px solid black;" type="button" value="Registrati" class="w3-button" onclick="registrati()">
    </form>
</body>

<?php

    require("functions.php");
    if(isset($_POST["email"]) && isset($_POST["password"])){
        if(checkIfLoginExists($_POST["email"],$_POST["password"])){
            $_SESSION["emailUtente"] = $_POST["email"];
            $_SESSION["sessionTime"] = time() + 3600;
            header("Location: azione.php");
        }
    }

?>
<script>
    function registrati(){
        window.location.href = "registrazione.php";
    }
    function tornaIndietro(){
        window.location.href = "index.html";
    }
</script>
</html>