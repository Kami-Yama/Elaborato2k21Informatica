<?php

    session_start();

?>

<!-- page used for the user to login thei accounts or to create a new one -->
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
    <link rel="stylesheet" href="generalStyles.css">
    <title>Coffee And Games - Login</title>
</head>

<?php

    //checks if the sessionTime of one hour it's still on. If not, then it will sign out the user
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

<!-- main body of the page -->
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
        <a href="registrazione.php" style="margin-top: 15px;border:1px solid black;"class="w3-button">Registrati</a>
    </form>
</body>

<?php

    //controls if all the inputs of the user are matching with an already existing account. If they do, it logs the account
    require("functions.php");
    if(isset($_POST["email"]) && isset($_POST["password"])){
        if(checkIfLoginExists($_POST["email"],$_POST["password"])){
            $_SESSION["emailUtente"] = $_POST["email"];
            $_SESSION["sessionTime"] = time() + 3600;
            header("Location: azione.php");
        }
    }

?>
</html>