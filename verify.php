<?php
include("config.php");
if(isset($_GET["key"])) {
    $key = $_GET["key"];
    
    $sql = "UPDATE `users` SET `Rank` = '1' WHERE `users`.`SecretKey` = '$key';";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    
    header("location: index.php");
}
?>