<?php
    require_once "config.php";
    session_start();

    $usr = $_SESSION['username'];

    $sqlGetUsrID = "SELECT id FROM users WHERE username=\"" . $usr . "\";";

    $usrID = mysqli_query($link, $sqlGetUsrID);

    $row = mysqli_fetch_assoc($usrID);
    $usrID = $row['id'];

    $sqlInsertStock = "INSERT INTO savedstocks VALUES (NULL,\"" . $_POST['newStk'] . "\", " . $usrID . ");";

    mysqli_query($link, $sqlInsertStock);
?>
