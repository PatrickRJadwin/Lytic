<?php
    session_start();

    $usr = $_SESSION['username'];
    $usr = ucfirst($usr);
    echo $usr;
?>
