<?php

    //Script para terminar todas as sessões abertas

    session_start();
    session_unset();
    session_destroy();
    header('Location: ../index.php');

    //

?>