<?php
include('../session.php');

$sql = "SELECT * FROM `users` WHERE `Email` = '$login_session';";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

if ($rank==2 && isset($_GET["Email"])) {
    $uEmail = $_GET["Email"];
    $oKey = $row["SecretKey"];
    $rand = random_str(100);
    $sql = "UPDATE `users` SET `SecretKey`='$rand' WHERE `Email`='$uEmail'";
    $resultK = mysqli_query($db,$sql);
    mysqli_query($db,"DELETE FROM `store` WHERE `secretKey` = '$oKey'");
    // 
    header("location: ../index.php");
} else {
    $rand = random_str(100);
    $oKey = $row["SecretKey"];
    $sql = "UPDATE `users` SET `SecretKey`='$rand' WHERE `Email`='$login_session'";
    $resultK = mysqli_query($db,$sql);
    mysqli_query($db,"DELETE FROM `store` WHERE `secretKey` = '$oKey'");
    header("location: ../index.php");
}

?>