<?php 
    require_once("db.php");
    $result = $mysqli->query("SELECT `nick`, `score` FROM `players` WHERE `score` > 0 ORDER BY `score` DESC LIMIT 4"); 
    for($players = []; $row = $result -> fetch_assoc(); $players[] = $row); 
    $players = json_encode($players);
    exit($players);
?>
