<?php

//function that generates the various first inputs after the firs form of the adminPanel
function genButtons($input){

    switch($input){

        case 1:
            //genero i bottoni per la gestione degli utenti
            echo '<form action="" method="GET"><input type="submit" value="Sospendi un Utente" name="removeUser" class="w3-button boxGrid" style="margin-right: 20px;"><input type="submit" value="Riabilita un Utente" name="ableUser" class="w3-button boxGrid"><input type="hidden" name="amISet" value="default"></form>';
            break;
        case 2:
            //genero i bottoni per la gestione degli eventi
            echo '<form action="" method="GET"><input type="submit" value="Aggiungi un Evento" name="addEvent" class="w3-button boxGrid" style="margin-right: 20px;"><input type="submit" value="Aggiungi Persone ad un Evento" name="addEventUser" class="w3-button boxGrid" style="margin-right: 20px;"><input type="submit" value="Aggiungi una Partecipazione" name="addPart" class="w3-button boxGrid" style="margin-right: 20px;"><input type="submit" value="Aggiungi un Pagamento" name="addPayment" class="w3-button boxGrid" style="margin-right: 20px;"><input type="submit" value="Aggiungi un Risultato" name="theResult" class="w3-button boxGrid"><input type="hidden" name="amISet" value="default"></form>';
            break;
        case 3:
            //genero i bottoni per la gestione delle prenotazioni
            echo '<form action="" method="GET"><input type="submit" value="Chiudi una Prenotazione" name="removePren" class="w3-button boxGrid" style="margin-right: 20px;"><input type="submit" value="Conferma una Prenotazione" name="confirmPren" class="w3-button boxGrid"><input type="hidden" name="amISet" value="default"></form>';
            break;
        case 4:
            //genero i bottoni per la gestione delle presenze
            echo '<form action="" method="GET"><input type="submit" value="Segna una Presenza" name="addPres" class="w3-button boxGrid" style="margin-right: 20px;"><input type="submit" value="Rimuovi una Presenza" name="removePres" class="w3-button boxGrid">        <input type="hidden" name="amISet" value="default"></form>';
            break;

    }

}

//method that generates a table based on the type of query needed
function genTable($nQuery){

    require("config.php");
    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    //based on the number of the query needed, generates a table with the columns from different queries
    switch($nQuery){
        case 1:
            $risultato = $mysqli->query("select * from clienti where sospensione <> '1'");
            break;
        case 2:
            $risultato = $mysqli->query("select P.id_prenotazione,P.data_inizio,P.data_fine, C.nome,C.cognome, P.postazione,P.data_pren,P.is_closed from prenotazioni as P natural join clienti as C where is_closed <> '1'");
            break;
        case 3:
            $risultato = $mysqli->query("select id_evento, Tema from eventi where data_fine > NOW()");
            break;
        case 4:
            $risultato = $mysqli->query("select * from presenze");
            break;
        case 5:
            $risultato = $mysqli->query("select * from clienti where sospensione <> '0'");
            break;
    }

    //html table code
    echo '<div class="container"><table id="table" class="w3-table w3-bordered w3-border w3-striped">';

    // ciclo per visualizzare la riga di intestazione della tabella con i nomi dei campi
    echo '<thead><tr class="w3-red">';
    $info_campi = $risultato->fetch_fields();
    foreach ($info_campi as $info_campo){
        echo '<th>'.$info_campo->name.'</th>';
    }

    echo '</tr></thead><tbody>';

    //dynamic generation of the rows of the table
    while ($riga = $risultato->fetch_row())
    {
        echo '<tr>';
        foreach($riga as $campo){
            echo '<td>'.$campo.'</td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>';
    $risultato->close();
}

//custom method that gets an id and, based on the number of the query, does something. It recycles a lot of code and permits me to use do all the queries in one spot instead of building a lot of different functions
function queryMonster($id,$queryNumber){

    require("config.php");
    $id = (int)$id;
    $queryNumber = (int)$queryNumber;

    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    //switch that contains the query
    switch($queryNumber){
        case 1:
            $mysqli->query("UPDATE clienti SET sospensione = '1' WHERE id_cliente = '$id'");
            break;
        case 2:
            $mysqli->query("UPDATE prenotazioni SET is_closed = '1' WHERE id_prenotazione = '$id'");
            break;
        case 3:
            $mysqli->query("DELETE FROM `presenze` WHERE id_presenza = '$id'");
            break;
        case 4:
            $mysqli->query("UPDATE `clienti` SET sospensione = '0' WHERE id_cliente = '$id'");
            break;
    }

    //feedback of success. If the query is successfull, it returns in the $_GET Array a positive feedback, if not, negative
    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }

}

//random function method. I'm really cheap with names, dunno how i came up with this one
function querySlave($id_cliente, $id_evento){

    require("config.php");
    $id_cliente = (int)$id_cliente;
    $id_evento = (int)$id_evento;

    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $mysqli->query("INSERT INTO `partecipanti`(`id_evento`, `id_cliente`, `haPagato`, `haPartecipato`, `posizionamento`) VALUES ($id_evento,$id_cliente,FALSE,FALSE,-1)");
    
    //feedback of success. If the query is successfull, it returns in the $_GET Array a positive feedback, if not, negative
    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }
}

//function of adding an event. Receives all the inputs and insert them in the database
function addEvento($tema, $descrizione, $premio, $ingresso, $data_init, $data_fine,$ora_init,$ora_end){

    require("config.php");

    $data_start = $data_init." ".$ora_init;
    $data_end = $data_fine." ".$ora_end;

    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $mysqli->query("INSERT INTO `eventi`(`premio`, `prezzo_ing`, `data_inizio`, `data_fine`,`tema`,`descrizione`) VALUES ('$premio','$ingresso','$data_start','$data_end','$tema','$descrizione')");

    
    //feedback of success. If the query is successfull, it returns in the $_GET Array a positive feedback, if not, negative
    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }

}

//functions that add a partecipation to the event based on the two id that it gets
function addPart($id_part,$id_evento){

    require("config.php");
    $id_part = (int)$id_part;
    $id_evento = (int)$id_evento;

    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $mysqli->query("UPDATE partecipanti SET haPartecipato = '1' WHERE id_cliente = '$id_part' AND id_evento = '$id_evento'");

    
    //feedback of success. If the query is successfull, it returns in the $_GET Array a positive feedback, if not, negative
    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }
}

//function that confirms a payment based on the two id that it gets
function addPayment($id_payment,$id_evento){

    require("config.php");
    $id_payment = (int)$id_payment;
    $id_evento = (int)$id_evento;

    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $mysqli->query("UPDATE partecipanti SET haPagato = '1' WHERE id_cliente = '$id_payment' AND id_evento = '$id_evento'");

    
    //feedback of success. If the query is successfull, it returns in the $_GET Array a positive feedback, if not, negative
    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }
}

//function that adds a result in an event, based on the id that it gets and the placement of the partecipant
function addResult($id_result,$id_evento,$risultato){

    require("config.php");
    $id_result = (int)$id_result;
    $id_evento = (int)$id_evento;

    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $result = $mysqli->query("UPDATE partecipanti SET posizionamento = '$risultato' WHERE id_cliente = '$id_result' AND id_evento = '$id_evento'");
    
    
    //feedback of success. If the query is successfull, it returns in the $_GET Array a positive feedback, if not, negative
    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }
}

//adds a presence to the database. Essential if something bad happens, since you can exactly know who was in the bar at the moment of the accident
function addPres($id_cliente,$isByod,$data_init,$data_fin,$ora_init,$ora_fin){

    $data_start = $data_init." ".$ora_init;
    $data_end = $data_fin." ".$ora_fin;

    require("config.php");
    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $mysqli->query("INSERT INTO `presenze`(`id_cliente`, `data_inizio`, `data_fine`,`pres_isBYOD`) VALUES ('$id_cliente','$data_start','$data_end','$isByod')");
    
    
    //feedback of success. If the query is successfull, it returns in the $_GET Array a positive feedback, if not, negative
    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }

}

//function that confirms a prenotation. Very useful for automating the presences that are done online
function prenConfirm($id){

    require("config.php");
    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $mysqli->query("INSERT INTO `presenze`(`id_cliente`, `data_inizio`, `data_fine`,`pres_isBYOD`) SELECT id_cliente, data_inizio, data_fine, 0 from prenotazioni where id_prenotazione = '$id'");
    
    
    //feedback of success. If the query is successfull, it returns in the $_GET Array a positive feedback, if not, negative
    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }    

}

?>