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
    <script src="help.js"></script>
    <title>Coffee And Games - Prenota</title>
</head>

<style>
    .contenitore{
        display: flex;
        flex-direction: column;
    }
</style>

<body class="w3-sand">
    <h1 style="margin-left: 10px;">
        Prenota Una Postazione!
    </h1>
    <h3 style="margin-left: 10px;">
        Assicuriamo la nostra disponibilità!
    </h3>
    <div id="errore">
    </div>
    <form id="registra" action="" method="POST" class="contenitore" style="margin-left: 10px; margin-top: 50px;">
        <div>
            <label style="margin-top: 50px;" class="w3-label">Data Iniziale</label>
            <input id="data" class="w3-text" type="date" name="data" placeholder="Inserisci una Data" style="width:7.7%;" required>
            <label style="margin-top: 50px;" class="w3-label">Ora Inizio</label>    
            <input id="ora" class="w3-text" type="time" name="ora" placeholder="Inserisci L'Ora" style="width:4.3%;" required>
        </div>    
        <div style="margin-top: 50px;">
            <label style="margin-top: 50px;" class="w3-label">Data Finale</label>
            <input id="dataFine" class="w3-text" type="date" name="dataFine" placeholder="Inserisci una Data" style="width:7.7%;" required>
            <label style="margin-top: 50px;" class="w3-label">Ora Fine</label>  
            <input id="oraFine" class="w3-text" type="time" name="oraFine" placeholder="Inserisci L'Ora" style="width:4.3%;" required>
        </div>

        <input type="submit" value="Effettua la Prenotazione" class="w3-button" style="border:1px solid black; margin-top: 50px; width:20%;">
    </form>

    <?php

        if(!isset($_POST["data"]) && !isset($_POST["ora"]) && !isset($_POST["dataFine"]) && !isset($_POST["oraFine"])){
            return;
        }

        $dataInizio = filter_var($_POST["data"], FILTER_SANITIZE_STRING);
        $dataFine = filter_var($_POST["dataFine"], FILTER_SANITIZE_STRING);
        $oraInizio = filter_var($_POST["ora"],FILTER_SANITIZE_STRING);
        $oraFine = filter_var($_POST["oraFine"],FILTER_SANITIZE_STRING);
        

        if(strcmp($dataInizio,date("Y-m-d")) < 0){
            echo '<h5 style="margin-top: 30px;">Non hai Inserito una Data Iniziale Adatta!</h5>';
            return;
        }

        if(strcmp($dataFine,$dataInizio) < 0){
            echo '<h5 style="margin-top: 30px;">Non hai Inserito una Data Finale Adatta!</h5>';
            return;
        }

        $timestamp = strtotime($dataInizio);

        $day = date('l', $timestamp);
        
        if(strcmp($day,'Monday') == 0 || strcmp($day,'Wednesday') == 0){
            echo '<h5 style="margin-top: 30px;">Spiacente, siamo chiusi il Lunedi e Mercoledi</h5>';
            return;
        }

        $timestamp2 = strtotime($dataFine);

        $day = date('l', $timestamp2);
        
        if(strcmp($day,'Monday') == 0 || strcmp($day,'Wednesday') == 0){
            echo '<h5 style="margin-top: 30px;">Spiacente, siamo chiusi il Lunedi e Mercoledi</h5>';
            return;
        }


        require("functions.php");

        if(($appoggio = checkIfPcAvaiable($dataInizio, $oraInizio, $dataFine, $oraFine)) == -1){
            echo '<h5 style="margin-top: 30px;">Spiacente, per questa ora tutte le postazioni sono Prenotate</h5>';
            return;
        }

        insertPren($dataInizio,$oraInizio,$dataFine,$oraFine,$appoggio);

    ?>
</body>
</html>