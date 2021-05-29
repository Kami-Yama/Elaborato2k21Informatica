<!-- page used for registering an user in the database -->
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
    <title>Coffee And Games - Registrati</title>
    <link rel="stylesheet" href="generalStyles.css">
</head>

<body class="w3-sand">
    <!-- no standard header here. It's the registration after all -->
    <div class="contenitore2">
        <h1 style="margin-left: 10px;">
            Registrati! <span style="font-size: 23px;">è gratis dopotutto...</span>
        </h1>
        <a type="button" style="border:1px solid black;margin-right: 20px;" class="w3-button" href="login.php">Torna al Login</a>
    </div>

    <hr style="border:1px solid black;"></hr>
    <div id="errore">
    </div>
    <!-- various data that will rappresent the user -->
    <form id="registra" action="" method="POST" class="contenitore" style="margin-left: 10px;">
        <label style="margin-top: 50px;" class="w3-label">Nome</label>
        <input id="nome" class="w3-text" type="text" name="nome" placeholder="Inserisci il tuo Nome" style="width:20%;" required>
        <label style="margin-top:20px;" class="w3-label">Cognome</label>
        <input id="cognome" class="w3-text" type="text" name="cognome" placeholder="Inserisci il tuo Cognome" style="width:20%;" required>
        <label style="margin-top:20px;" class="w3-label">Data di Nascita</label>
        <input id="dataNasc" class="w3-text" type="date" name="dataNasc" placeholder="Inserisci la tua Data di Nascita" style="width:20%;" required>
        <label style="margin-top:20px;" class="w3-label">Email</label>
        <input id="email" class="w3-text" type="text" name="email" placeholder="Inserisci la tua Email" style="width:20%;" required>
        <label style="margin-top:20px;" class="w3-label">Telefono</label>
        <input id="telefono" class="w3-text" type="text" name="telefono" placeholder="Inserisci il tuo Numero di Telefono" style="width:20%;" required>
        <label style="margin-top: 20px;" class="w3-label">Password |Deve essere compresa tra 6 e 20 caratteri senza contenere caratteri speciali|</label>
        <input id="password" type="password" name="password" placeholder="Inserisci la password da usare" style="width:20%" required>
        <label style="margin-top: 20px;" class="w3-label">Reinserisci la Password</label>
        <input id="password2" type="password" name="password2" placeholder="Reinserisci la password da usare" style="width:20%" required>
        <input style="margin-top: 30px;border:1px solid black; width:10%;" type="button" value="Registrati" class="w3-button" onclick="checkErrori()">
    </form>

<?php

    //when the forms submit, it will register the account
    require("functions.php");
    if(isset($_POST["password"])){
        registraAccount($_POST["nome"],$_POST["cognome"],$_POST["password"],$_POST["email"],$_POST["telefono"],$_POST["dataNasc"]);
    }

?>

</body>

<script>

    /*long story short. These are CLIENT INPUT CONTROLS, since i wanted to differentiate from the usual only server controls that are done the 90% of the time. Here, the big part of controls are done client side. This lets the user insert in the database silly things, but just for the sake of knowledge and just for this page, i decided to check them in this way.

    pros of this checks
    - Done in javascript, they are really useful to check things even beyond the usual client service. They can redirect the normal user to do decent choices

    negatives of this checks
    - the security of the site is in danger. In fact, in these checks i send all the emails to the client, so an expert hacker could understand how much user in the database i got and who are registered to the site. This is a HUGE bad practice to do in a site, but just for showing, i decided to let it happen. I would not normally do such checks in this way, but in this particular situation, it was needed.
    SQL Injections are prevented the same, since i added at least basic controls in the server side
    */
    function checkErrori(){

        const email = document.getElementById("email");
        const nome = document.getElementById("nome");
        const cognome = document.getElementById("cognome");
        const password = document.getElementById("password");
        const passwordCheck = document.getElementById("password2");
        const dataNasc = document.getElementById("dataNasc");
        const telefono = document.getElementById("telefono");
        const allEmails = <?php getAllEmailJSON(); ?>

        console.log(dataNasc.value);
        
        console.log(email.value);
        var passw = /^[a-zA-Z0-9!@#$%^&*]{6,16}$/;
        var telefonoCheck = /^[0-9]{10}$/;

        //all the various checks can be easily found here
        if(nome.value && nome.value != ""){
            console.log("ciao");
            if(cognome.value &&  cognome.value != ""){
                console.log("ciao2");
                if(telefono.value.match(telefonoCheck)){
                    if(checkIfLegal(dataNasc.value)){
                        if(email.value && email.value != "" && checkIfEmailIsFree(email.value,allEmails)){
                            if(password.value.match(passw)){
                                if(password.value == passwordCheck.value){
                                    document.getElementById("registra").submit();
                                    document.getElementById("errore").innerHTML = "";

                                }
                                else{
                                    document.getElementById("errore").innerHTML = "ERRORE : La password da Reinserire non è Corretta"
                                }
                            }
                            else{
                                document.getElementById("errore").innerHTML = "ERRORE : La password non ha un formato valido! Deve essere compresa tra 6 e 20 caratteri, contenere solo lettere o numeri e il primo carattere deve essere una lettera."
                            }
                        }
                        else{
                            document.getElementById("errore").innerHTML = "ERRORE : Questa Email non è disponibile o non è valida."
                        }
                    }
                    else{
                        document.getElementById("errore").innerHTML = "ERRORE : L'età che hai inserito non è valida. Sicuro di essere Maggiorenne o di respirare ancora?";
                    }
                    
                }
                else{
                    document.getElementById("errore").innerHTML = "ERRORE : Non hai inserito un Numero Di Telefono Adatto!"
                } 
            }
            else{
                document.getElementById("errore").innerHTML = "ERRORE : Non hai inserito un Cognome!"
            }
        }
        else{
            document.getElementById("errore").innerHTML = "ERRORE : Non hai inserito un Nome!"
        }
    }

</script>
</html>