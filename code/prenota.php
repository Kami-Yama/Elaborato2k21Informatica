
<!-- page used to set up a prenotation by the client-->
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
    <link rel="stylesheet" href="generalStyles.css">
    <title>Coffee And Games - Prenota</title>
</head>

<body class="w3-sand">
    <!-- login standard header --> 
    <?php require("loginHeader.php");?>
    <div>
        <a style="border:1px solid black;" type="button" class="w3-button" href="index.php">Ritorna Alla Home</a>
        <a style="margin-right: 10px;border:1px solid black;" type="button" class="w3-button" href="logout.php">Logout</a>
    </div>
    </header>

    <!-- page main content -->
    <hr style="border: 1px solid black;">
    <div class="contenitore">
        <h1 style="margin-left: 10px;">
            Prenota Una Postazione
        </h1>
        <h3 style="margin-left: 10px;">
            Assicuriamo la nostra disponibilità!
        </h3>
        <div id="errore">
        </div>
        <!-- form with the inputs that the user has to insert -->
        <form id="registra" action="" method="POST" style="margin-left: 10px; margin-top: 50px;">
        <div>
            <label style="margin-top: 50px;" class="w3-label">Data Iniziale</label>
            <input id="data" class="w3-text" type="date" name="data" placeholder="Inserisci una Data" required>
            <label style="margin-top: 50px;" class="w3-label">Ora Inizio</label>    
            <input id="ora" class="w3-text" type="time" name="ora" placeholder="Inserisci L'Ora" required>
        </div>    
        <div style="margin-top: 50px;">
            <label style="margin-top: 50px;" class="w3-label">Data Finale</label>
            <input id="dataFine" class="w3-text" type="date" name="dataFine" placeholder="Inserisci una Data"  required>
            <label style="margin-top: 50px;" class="w3-label">Ora Fine</label>  
            <input id="oraFine" class="w3-text" type="time" name="oraFine" placeholder="Inserisci L'Ora"  required>
        </div>

        <input type="submit" value="Effettua la Prenotazione" class="w3-button" style="border:1px solid black; margin-top: 50px;">
        </form>


    <?php

        //various checks to control if the inputs are fine
        if(!isset($_POST["data"]) && !isset($_POST["ora"]) && !isset($_POST["dataFine"]) && !isset($_POST["oraFine"])){
            return;
        }

        //sanitize the inputs
        $dataInizio = filter_var($_POST["data"], FILTER_SANITIZE_STRING);
        $dataFine = filter_var($_POST["dataFine"], FILTER_SANITIZE_STRING);
        $oraInizio = filter_var($_POST["ora"],FILTER_SANITIZE_STRING);
        $oraFine = filter_var($_POST["oraFine"],FILTER_SANITIZE_STRING);
        
        //compares if the prenotation is at least after the current day (since you can't do prenotations in the past)
        if(strcmp($dataInizio,date("Y-m-d")) < 0){
            echo '<h5 style="margin-top: 50px;">Non hai Inserito una Data Iniziale Adatta!</h5>';
            return;
        }

        //controls if the date of start it's bigger than the date of finish (since you can't finish a prenotation in the past)
        if(strcmp($dataFine,$dataInizio) < 0){
            echo '<h5 style="margin-top: 50px;">Non hai Inserito una Data Finale Adatta!</h5>';
            return;
        }

        $timestamp = strtotime($dataInizio);

        $day = date('l', $timestamp);
        
        //controls if the date is different from monday and wednesday (since the caffe it's closed on those days). This for the start date
        if(strcmp($day,'Monday') == 0 || strcmp($day,'Wednesday') == 0){
            echo '<h5 style="margin-top: 50px;">Spiacente, siamo chiusi il Lunedi e Mercoledi</h5>';
            return;
        }

        //controls, if the day it's the same, that the starting hour is bigger than the end hour (since you cant finish the prenotation in the past)
        if(strcmp($oraInizio,$oraFine) > 0 && strcmp($dataInizio,$dataFine) == 0){
            echo '<h5 style="margin-top: 50px;">Hai selezionato un\'ora di Inizio maggiore dell\'ora di Fine</h5>';
            return;
        }
        

        $timestamp2 = strtotime($dataFine);

        $day = date('l', $timestamp2);
        
        //controls if the date is different from monday and wednesday (since the caffe it's closed on those days). This for the ending date
        if(strcmp($day,'Monday') == 0 || strcmp($day,'Wednesday') == 0){
            echo '<h5 style="margin-top: 50px;">Spiacente, siamo chiusi il Lunedi e Mercoledi</h5>';
            return;
        }
        
        //checks if there are any computers avaiable for the prenotation in that hour phase
        if(($appoggio = checkIfPcAvaiable($dataInizio, $oraInizio, $dataFine, $oraFine)) == NULL){
            echo '<h5 style="margin-top: 50px;">Spiacente, per questa ora tutte le postazioni sono Prenotate</h5>';
            return;
        }

        //inserts the prenotation in the database
        insertPren($dataInizio,$oraInizio,$dataFine,$oraFine,$appoggio);

    ?>
    </div>
</body>
</html>