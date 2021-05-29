<?php session_start();?>

<!-- simple header of the page. used as a template for helping stabilizing the site and writing less code-->
<header class="contenitore2">
    <div class="flexbox">
        <h3 style="margin-left: 10px;">
            Coffee And Games - Valdagno |
        </h3>
        <div class="w3-padding">
            Per momenti fantastici, Insieme
        </div>
    </div>
    <div style="margin-left: auto;">
    <?php
        require("functions.php");
        if((isset($_SESSION["emailUtente"]))){
            if((time() - $_SESSION["sessionTime"]) < 3600){
                $righe = getLoginSessionInfo($_SESSION["emailUtente"]);
                echo '<p style="margin-right: 20px;">Benvenuto, <strong>'.$righe[0]." ".$righe[1].'</strong>';
            }
            else{                   
                session_destroy();
            }
        }
        else{
            echo "Non sei Loggato";
        }
    ?>
    </div>
