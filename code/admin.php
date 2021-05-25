<?php

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
            echo '<form action="" method="GET"><input type="submit" value="Chiudi una Prenotazione" name="removePren" class="w3-button boxGrid"><input type="hidden" name="amISet" value="default"></form>';
            break;
        case 4:
            //genero i bottoni per la gestione delle presenze
            echo '<form action="" method="GET"><input type="submit" value="Segna una Presenza" name="addPres" class="w3-button boxGrid" style="margin-right: 20px;"><input type="submit" value="Rimuovi una Presenza" name="removePres" class="w3-button boxGrid">        <input type="hidden" name="amISet" value="default"></form>';
            break;

    }

}

function genTable($nQuery){

    require("config.php");
    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    switch($nQuery){
        case 1:
            $risultato = $mysqli->query("select * from clienti where sospensione <> '1'");
            break;
        case 2:
            $risultato = $mysqli->query("select * from prenotazioni where is_closed <> '1'");
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

    echo '<div class="container"><table id="table" class="w3-table w3-bordered w3-border w3-striped">';

    // ciclo per visualizzare la riga di intestazione della tabella con i nomi dei campi
    echo '<thead><tr class="w3-red">';
    $info_campi = $risultato->fetch_fields();
    foreach ($info_campi as $info_campo){
        echo '<th>'.$info_campo->name.'</th>';
    }

    echo '</tr></thead><tbody>';

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

function queryMonster($id,$queryNumber){

    require("config.php");
    $id = (int)$id;
    $queryNumber = (int)$queryNumber;

    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

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

    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }

}

function querySlave($id_cliente, $id_evento){

    require("config.php");
    $id_cliente = (int)$id_cliente;
    $id_evento = (int)$id_evento;

    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $mysqli->query("INSERT INTO `partecipanti`(`id_evento`, `id_cliente`, `haPagato`, `haPartecipato`, `posizionamento`) VALUES ($id_evento,$id_cliente,FALSE,FALSE,-1)");

    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }
}

function addEvento($tema, $descrizione, $premio, $ingresso, $data_init, $data_fine,$ora_init,$ora_end){

    require("config.php");

    $data_start = $data_init." ".$ora_init;
    $data_end = $data_fine." ".$ora_end;

    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $mysqli->query("INSERT INTO `eventi`(`premio`, `prezzo_ing`, `data_inizio`, `data_fine`,`tema`,`descrizione`) VALUES ('$premio','$ingresso','$data_start','$data_end','$tema','$descrizione')");

    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }

}

function addPart($id_part,$id_evento){

    require("config.php");
    $id_part = (int)$id_part;
    $id_evento = (int)$id_evento;

    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $mysqli->query("UPDATE partecipanti SET haPartecipato = '1' WHERE id_cliente = '$id_part' AND id_evento = '$id_evento'");

    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }
}

function addPayment($id_payment,$id_evento){

    require("config.php");
    $id_payment = (int)$id_payment;
    $id_evento = (int)$id_evento;

    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $mysqli->query("UPDATE partecipanti SET haPagato = '1' WHERE id_cliente = '$id_payment' AND id_evento = '$id_evento'");

    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }
}

function addResult($id_result,$id_evento,$risultato){

    require("config.php");
    $id_result = (int)$id_result;
    $id_evento = (int)$id_evento;

    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $result = $mysqli->query("UPDATE partecipanti SET posizionamento = '$risultato' WHERE id_cliente = '$id_result' AND id_evento = '$id_evento'");
    
    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }
}

function addPres($id_cliente,$isByod,$data_init,$data_fin,$ora_init,$ora_fin){

    $data_start = $data_init." ".$ora_init;
    $data_end = $data_fin." ".$ora_fin;

    require("config.php");
    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");

    $mysqli->query("INSERT INTO `presenze`(`id_cliente`, `data_inizio`, `data_fine`,`pres_isBYOD`) VALUES ('$id_cliente','$data_start','$data_end','$isByod')");
    
    if ( $mysqli->affected_rows > 0) {
        header("Location: adminPanel.php?checkQuery=Azione Riuscita!");
    }
    else{
        header("Location: adminPanel.php?checkQuery=Azione Fallita! Hai Inserito dei Dati Validi?");
    }

}

?>