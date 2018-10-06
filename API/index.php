<?php
include("../config.php");
//   {"result":"val","message":"msg"}
if(isset($_GET["secretKey"])) {
    $sKey = mysqli_real_escape_string($db,$_GET['secretKey']);
    $sql = "SELECT * FROM `users` WHERE `SecretKey` = '$sKey';";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1) {
        if($row["Rank"]>=1) {
            if(isset($_GET["key"]) && isset($_GET["value"])){
                $key = mysqli_real_escape_string($db,$_GET["key"]);
                $value = mysqli_real_escape_string($db,$_GET["value"]);
                $nKey = $key.".".$sKey;
                $sql = "REPLACE INTO `store` (`keyValue`,`value`,`secretKey`) VALUES ('$nKey','$value','$sKey');";
                $resultK = mysqli_query($db,$sql);
                echo '{"result":"Success","message":""}';
            } elseif (isset($_GET["key"])){
                $key = mysqli_real_escape_string($db,$_GET["key"]);
                $nKey = $key.".".$sKey;
                $sql = "SELECT `value` FROM `store` WHERE `keyValue` = '$nKey' and `secretKey` = '$sKey';";
                $resultK = mysqli_query($db,$sql);
                $rowK = mysqli_fetch_array($resultK,MYSQLI_ASSOC);
                if($rowK){
                    echo '{"result":"Success","message":"'. $rowK["value"] .'"}';
                } else {
                    echo '{"result":"Error","message":"Invalid key."}';
                }
            }
        } else {
            echo '{"result":"Error","message":"Not verified."}';
        }
    } else {
        echo '{"result":"Error","message":"Invalid secret key."}';
    }

    //echo "$count";
} else {
    echo '{"result":"Error","message":"No secret key."}';
}

?>