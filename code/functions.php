<?php

function registraAccount($nomeSan,$cognomeSan, $passwordSan, $emailSan, $numeroTelSan, $dataNascSan){

    require("config.php");
    //sanitize input

    $nome = filter_var($nomeSan, FILTER_SANITIZE_STRING);
    $cognome = filter_var($cognomeSan, FILTER_SANITIZE_STRING);
    $hash = password_hash($passwordSan, PASSWORD_DEFAULT);
    $email = filter_var($emailSan, FILTER_SANITIZE_EMAIL);
    $numeroTel = filter_var($numeroTelSan, FILTER_SANITIZE_NUMBER_INT);
    
    $mysqli = new mysqli($host, $username, $password, $db_name);

    if (!$mysqli->connect_error)
    {		
        $mysqli->set_charset("utf8"); 			

        $sql = "insert into CLIENTI (email,nome,cognome,password,telefono,dataRegistrazione,sospensione) values ('$email','$nome','$cognome','$hash','$numeroTel', NOW(), FALSE)";
		
        $mysqli->query($sql);

        $mysqli->close();

    }

    header("Location: endRegister.html");
}

function getAllEmailJSON()
{
    require("config.php");
    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");
    $risultato = $mysqli->query("select email from CLIENTI"); 

    $righe = $risultato->fetch_all(MYSQLI_ASSOC);

    echo json_encode($righe);
    
    $risultato->close();
    $mysqli->close();
}



function checkIfLoginExists($email, $passwordSend){

    require("config.php");
    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");
    $risultato = $mysqli->query("select email,password from CLIENTI"); 
    $errorType = 1;

    while ($riga = $risultato->fetch_row())
    {
        if(strcmp($riga[0],$email) == 0){
            if(password_verify($passwordSend,$riga[1])){
                echo "successo";
                return true;
            }
            else{
                echo '<strong class="contenitore">ERRORE: La password inserita non è Corretta!</strong>';
                $errorType = 2;
            }
        }
    }

    if($errorType == 1)
        echo '<strong class="contenitore">ERRORE: L'."'".'account non è Registrato!</strong>';
    
    $risultato->close();
    $mysqli->close();

    return false;

}

function checkIfAdmin($emailUtente){

    $utentiAdmin = array(
        "nicolocornale.es@gmail.com"
    );

    for($i=0; $i<count($utentiAdmin); $i++){
        if(strcmp($emailUtente,$utentiAdmin[$i]) == 0){
            return true;
        }
    }
    return false;

}

function checkIfLoginAvaiable(){

    $check = false;
    if((isset($_SESSION["emailUtente"]))){
        if(time() - $_SESSION["sessionTime"] > 3600){
            $check = true;
            echo $check;
        }
        else{
            session_destroy();
            echo $check;
        }
    }

}

function getLoginSessionInfo($emailCheck){
    

    require("config.php");
    $mysqli = new mysqli($host, $username, $password, $db_name);
    $mysqli->set_charset("utf8");
    $risultato = $mysqli->query("select nome,cognome from CLIENTI where email = '$emailCheck'"); 
        
    $righe = $risultato->fetch_row();
        
    return $righe;
            
    $risultato->close();
    $mysqli->close();

}


?>