<?php

    //simply destroys the session and log out the user
    session_start();
    session_destroy();
    header("Location: index.php");

?>