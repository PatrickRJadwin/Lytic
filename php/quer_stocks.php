<?php
    require_once "config.php";
    session_start();

    $usr = $_SESSION['username'];

    $sqlGetUsrID = "SELECT id FROM users WHERE username=\"" . $usr . "\";";

    $usrID = mysqli_query($link, $sqlGetUsrID);

    $row = mysqli_fetch_assoc($usrID);
    $usrID =  $row['id'] . "\n";

    $sqlGetStocks = "SELECT stocktag FROM savedstocks WHERE userid =\"" . $usrID . "\";";

    $usrStocks = mysqli_query($link, $sqlGetStocks);
    
    $arrStocks = array();
    
    $rowcnt = mysqli_num_rows($usrStocks);
    
    if ($rowcnt > 0) {
        while ($row = mysqli_fetch_assoc($usrStocks)) {
            echo "<tr>\n";
            echo "<td class=\"align-middle\">\n";
            echo "<a href=\"javascript:void(0)\" onclick=\"clickChange('" . $row['stocktag'] . "');\" class=\"text-dark\">" . $row['stocktag'] . "</a>\n";
            echo "</td>\n";
            echo "</tr>\n";
        }
    }
    else {
        echo "";
    }
?>
