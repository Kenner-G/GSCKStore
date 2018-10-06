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
    $sKey = $row["SecretKey"];
    $headers = 'From: noreply@gsck.co.uk' . "\r\n" .
                'Reply-To: noreply@gsck.co.uk' . "\r\n" .
                'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                'X-Mailer: GSCKMailer';
            mail($uEmail, "GSCKStore Verification", "<h3>Verification</h3><br><p>Please click <a href='http://gsck.co.uk/dashboard/verify.php?key=$rand'>here</a> to verify your email.<br>Or copy this http://gsck.co.uk/dashboard/verify.php?key=$rand</p>
    header("location: ../index.php");
}

?>