<?php
    require("admin.php"); //require of admin.php
?>

<!-- basic html head, with various imports-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="adminStyles.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <title>Coffee And Games - Amministra</title>
</head>

<!-- start of the body-->
<body class="w3-sand">
    <header class="flexbox" style="justify-content: space-between; align-items: center; height: 100px;">
        <h3 style="margin-left: 10px;">
            Amministrazione DB
        </h3>
        
        <div class="w3-padding">
            <a type="button" style="border:1px solid black;" class="w3-button" href="logout.php">Logout</a>
            <a type="button" style="border:1px solid black;" class="w3-button" href="index.php">Home</a>
        </div>
    </header>

    <!-- main container of the page-->
    <div class="flexbox">
        <form action="" method="GET" class="grid">
            <input type="submit" value="Utenti" name="gestUtente" class="w3-button boxGrid">
    
            </input>
            <input type="submit" value="Eventi" name="gestEventi" class="w3-button boxGrid">
    
            </input>
            <input type="submit" value="Prenotazioni" name="gestPren" class="w3-button boxGrid">
    
            </input>
            <input type="submit" value="Presenze" name="gestPres" class="w3-button boxGrid">
    
            </input>
        </form>
        <!-- start of the dynamic container of the page -->
        <div class="containerInfo boxGrid" style="height: 700px; width: 100%;">
            <?php
            
                //various get methods. They check if something has been done, if else, they go forward. They are used to send the various data to the various functions in admin.php
                if(isset($_GET["checkQuery"])){
                    echo $_GET["checkQuery"];
                }

                if(isset($_GET["actionDone"])){
                    queryMonster($_GET["id"],$_GET["queryMonsterValue"]);                 
                }

                if(isset($_GET["prenConfirm"])){
                    prenConfirm($_GET["id"]);         
                }

                if(isset($_GET["eventUserLinked"])){
                    querySlave($_GET["clientId"],$_GET["eventId"]);              
                }

                if(isset($_GET["eventAdd"])){
                    addEvento($_GET["tema"],$_GET["desc"],$_GET["premio"],$_GET["ingresso"],$_GET["data_init"],$_GET["data_end"],$_GET["ora_init"],$_GET["ora_end"]);
                }

                if(isset($_GET["presAdd"])){
                    $variable = false;
                    if(isset($_GET["isBYOD"]))
                        $variable = true;

                    addPres($_GET["idCliente"],$variable,$_GET["data_init"],$_GET["data_end"],$_GET["ora_init"],$_GET["ora_end"]);
                        
                }

                if(isset($_GET["addPartEnd"])){
                    addPart($_GET["partId"],$_GET["eventId"]);
                }

                if(isset($_GET["addPay"])){
                    addPayment($_GET["idPagato"],$_GET["eventId"]);
                }

                if(isset($_GET["addResult"])){
                    addResult($_GET["idResult"],$_GET["eventId"],$_GET["result"]);
                }

                //first input manager. Based on which button i pressed in the starting file, it sends it to genButtons

                $input = 0;
                if(isset($_GET["gestUtente"])){
                    $input = 1;
                }
                if(isset($_GET["gestEventi"])){
                    $input = 2;
                }
                if(isset($_GET["gestPren"])){
                    $input = 3;
                }
                if(isset($_GET["gestPres"])){
                    $input = 4;
                }

                genButtons($input);

                //checks if the hidden attribute "amISet" is set. If it is, it starts searching for the form that it has to create, and it does it.
                if(isset($_GET["amISet"])){
                    
                    //creates the tables and the form for suspending an User
                    if(isset($_GET["removeUser"])){
                        genTable(1);
                        echo '<form action="" method="GET">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id da Sospendere</label>
                        <input type="number" placeholder="Id" name="id" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <input type="submit" value="Sospendi" name="actionDone" class="w3-button boxGrid" style="margin-top:20px;">
                        <input type="hidden" value="1" name="queryMonsterValue"> 
                        </form>';
                    }
                    //creates the tables and the form for permitting a suspended user to use the site again
                    if(isset($_GET["ableUser"])){
                        genTable(5);
                        echo '<form action="" method="GET">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id da Riabilitare</label>
                        <input type="number" placeholder="Id" name="id" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <input type="submit" value="Riabilita" name="actionDone" class="w3-button boxGrid" style="margin-top:20px;">
                        <input type="hidden" value="4" name="queryMonsterValue"> 
                        </form>';
                    }

                    //creates the tables and the form for adding a new Event.
                    if(isset($_GET["addEvent"])){
                        echo '<form action="" method="GET">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci il Tema dell\'Evento</label>
                        <input type="text" placeholder="Inserisci il Tema" name="tema" class="w3-input boxGrid" style="width:500px;" margin-top: 20px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci il Premio dell\'Evento</label>
                        <input type="number" placeholder="Premio in Soldi" name="premio" class="w3-input boxGrid" style="width:200px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci la parcella d\'ingresso dell\'Evento</label>
                        <input type="number" placeholder="Parcella di Ingresso" name="ingresso" class="w3-input boxGrid" style="width:200px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci la descrizione dell\'Evento</label>
                        <input type="text" placeholder="Inserisci la Descrizione" name="desc" class="w3-input boxGrid" style="width:800px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci la data d\'inizio dell\'Evento</label>
                        <input type="date" placeholder="Id" name="data_init" class="w3-input boxGrid" style="width:150px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\' ora d\'inizio dell\'Evento</label>
                        <input type="time" placeholder="Id" name="ora_init" class="w3-input boxGrid" style="width:150px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci la data della fine dell\'Evento</label>
                        <input type="date" placeholder="Id" name="data_end" class="w3-input boxGrid" style="width:150px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\' ora di fine dell\'Evento</label>
                        <input type="time" placeholder="Id" name="ora_end" class="w3-input boxGrid" style="width:150px;" margin-top: 10px;">
                        <input type="submit" value="Inserisci Evento" name="eventAdd" class="w3-button boxGrid" style="margin-top:20px;">

                        </form>';
                    }
                    //creates the tables and the form for adding an User to an Event
                    if(isset($_GET["addEventUser"])){
                        genTable(1);
                        genTable(3);
                        echo '<form action="" method="GET">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id dell\'Evento</label>
                        <input type="number" placeholder="Id" name="eventId" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id del cliente da Aggiungere</label>
                        <input type="number" placeholder="Id" name="clientId" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <input type="submit" value="Inserisci Valore" name="eventUserLinked" class="w3-button boxGrid" style="margin-top:20px;">
                        </form>';
                    }
                    //creates the tables and the form for confirm an user partecipation to an event
                    if(isset($_GET["addPart"])){
                        genTable(1);
                        genTable(3);
                        echo '<form action="" method="GET">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id dell\'Evento</label>
                        <input type="number" placeholder="Id" name="eventId" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id del Cliente che ha Partecipato</label>
                        <input type="number" placeholder="Id" name="partId" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <input type="submit" value="Inserisci Partecipazione" name="addPartEnd" class="w3-button boxGrid" style="margin-top:20px;">
                        </form>';
                    }
                    //creates the tables and the form to confirm an user entry-fee to an event
                    if(isset($_GET["addPayment"])){
                        genTable(1);
                        genTable(3);
                        echo '<form action="" method="GET">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id dell\'Evento</label>
                        <input type="number" placeholder="Id" name="eventId" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id del Cliente che ha Pagato</label>
                        <input type="number" placeholder="Id" name="idPagato" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <input type="submit" value="Inserisci Pagamento" name="addPay" class="w3-button boxGrid" style="margin-top:20px;">
                        </form>';
                    }
                    //creates the tables and the form to confirm an user result in an event
                    if(isset($_GET["theResult"])){
                        genTable(1);
                        genTable(3);
                        echo '<form action="" method="GET">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id dell\'Evento</label>
                        <input type="number" placeholder="Id" name="eventId" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id del Cliente che ha Partecipato</label>
                        <input type="number" placeholder="Id" name="idResult" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci la posizione nella quale ha finito il Cliente</label>
                        <input type="number" placeholder="Id" name="result" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <input type="submit" value="Inserisci Risultato" name="addResult" class="w3-button boxGrid" style="margin-top:20px;">
                        </form>';
                    }
                    //creates the tables and the form to remove an user prenotation (since the client might have some trouble coming etc...)
                    if(isset($_GET["removePren"])){
                        genTable(2);
                        echo '<form action="" method="GET">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id della Prenotazione da Disdire</label>
                        <input type="number" placeholder="Id" name="id" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <input type="submit" value="Chiudi" name="actionDone" class="w3-button boxGrid" style="margin-top:20px;">
                        <input type="hidden" value="2" name="queryMonsterValue"> 
                        </form>';
                        
                    }
                    //creates the tables and the form for confirming a prenotation and placing the presence
                    if(isset($_GET["confirmPren"])){
                        genTable(2);
                        echo '<form action="" method="GET">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id della Prenotazione da Confermare</label>
                        <input type="number" placeholder="Id" name="id" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <input type="submit" value="Conferma" name="prenConfirm" class="w3-button boxGrid" style="margin-top:20px;">
                        </form>';
                        
                    }
                    //creates the tables and the form for confirming a presence
                    if(isset($_GET["addPres"])){
                        genTable(1);
                        echo '<form action="" method="GET">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci il Cliente che effettua la Presenza</label>
                        <input type="number" placeholder="Inserisci l\'id del Cliente" name="idCliente" class="w3-input boxGrid" style="width:210px;" margin-top: 20px;">
                        <label style="margin-top: 20px;" class="w3-label">Il Cliente ha un suo PC?</label>
                        <input type="checkbox" class="checkBox" name="isBYOD" class="w3-input boxGrid" style="margin-top: 10px;">
                        <p><label style="margin-top: 20px;" class="w3-label">Inserisci la data d\'inizio della Presenza</label></p>
                        <input type="date" placeholder="Id" name="data_init" class="w3-input boxGrid" style="width:150px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\' ora d\'inizio della Presenza</label>
                        <input type="time" placeholder="Id" name="ora_init" class="w3-input boxGrid" style="width:150px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci la data della fine della Presenza</label>
                        <input type="date" placeholder="Id" name="data_end" class="w3-input boxGrid" style="width:150px;" margin-top: 10px;">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\' ora di fine della Presenza</label>
                        <input type="time" placeholder="Id" name="ora_end" class="w3-input boxGrid" style="width:150px;" margin-top: 10px;">
                        <input type="submit" value="Inserisci Presenza" name="presAdd" class="w3-button boxGrid" style="margin-top:20px;">

                        </form>';
                    }
                    //creates the tables and the form to remove a presence
                    if(isset($_GET["removePres"])){
                        genTable(4);
                        echo '<form action="" method="GET">
                        <label style="margin-top: 20px;" class="w3-label">Inserisci l\'id della Presenza da Cancellare</label>
                        <input type="number" placeholder="Id" name="id" class="w3-input boxGrid" style="width:100px;" margin-top: 10px;">
                        <input type="submit" value="Chiudi" name="actionDone" class="w3-button boxGrid" style="margin-top:20px;">
                        <input type="hidden" value="3" name="queryMonsterValue"> 
                        </form>';
                    }

                }

            ?>
        </div>
    </div>
    
    <footer class="flexbox" style="justify-content: space-around; height: 100px; align-items: center;">
        <nav>
            <a href="logout.php">Logout</a> |
            <a href="index.php">Home</a> 
          </nav> 
    </footer>
    
</body>

<script>

$(document).ready(function() { $('#table').DataTable( { language: { url: "lib/italian.json" } } ); });

</script>

</html>