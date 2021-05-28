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
    <title>Coffee And Games - Main</title>
    <link rel="stylesheet" href="generalStyles.css">
</head>

<body class="w3-sand">
    <?php require("loginHeader.php");?>
        <div class="w3-padding">
            <a type="button" style="border:1px solid black;" class="w3-button" href="login.php">Prenota</a>
            <a type="button" style="border:1px solid black;" class="w3-button" href="about.html">Chi Siamo</a>
            <a type="button" style="border:1px solid black;" class="w3-button" href="rules.html">Regole</a>
        </div>
    </header>
    <hr style="border: 1px solid black;">

    <div class="flexbox">
        <img src="img/gamingbarback.jpg" style="margin-top: 100px;" class="imglayout">
        <div style="width: 100%;">
            <h3>
                Unisciti a tutti gli Appassionati dell'Internet Valdagnesi per avventurarti in una nuova realtà, tutta nuova da scoprire!
                Siamo <strong>Aperti</strong> dal <strong>Martedì alla Domenica,</strong> <strong>24 ore su 24!</strong>
                <strong>Prenota</strong> subito su questo sito, <strong>cliccando il tasto in Alto a Destra!</strong>
            </h3>
        </div>
    </div>
    <hr style="border: 1px solid black; margin-top: 100px;">
    <footer class="flexbox" style="justify-content: space-around;">
        <nav>
            <a href="login.php">Prenota</a> |
            <a href="about.html">Chi Siamo</a> |
            <a href="rules.html">Regole</a> |
            <a href="login.php">Amministra</a>
          </nav> 
    </footer>
    
</body>

</html>