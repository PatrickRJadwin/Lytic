<?php
    require_once "config.php";
    session_start();
    
    $usr = $_SESSION['username'];

    $sqlGetUsrID = "SELECT id FROM users WHERE username=\"" . $usr . "\";";

    $usrID = mysqli_query($link, $sqlGetUsrID);

    $row = mysqli_fetch_assoc($usrID);
    $usrID = $row['id'];
    
    $sqlRemoveStock = "DELETE FROM savedstocks WHERE stocktag = '" . $_POST['removeStk'] . "' AND userid = " . $usrID . ";";
    mysqli_query($link, $sqlRemoveStock);
?>
