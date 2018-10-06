<?php
    include('session.php');

    
    $sql = "SELECT * FROM `users` WHERE `Email` = '$login_session';";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $rank = $row['Rank'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GSCKStore</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        div.cent {
            width: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">GSCK <span class="badge badge-secondary">Beta</span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Dashboard <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>



<div class="cent">
    <h1>Welcome, <b><?php echo $row["Username"]; ?></b></h1>
    <p>
        This site is currently in development.<br><br>
        <?php
            if($rank == 0){
                echo "Please check your email to verify. if it isn't there check your Junk folder.";
            } else {
                echo  "Secret key (Keep this a secret): <b>". $row['SecretKey'] ."</b><br>Get the Roblox module <a href='https://www.roblox.com/library/2446004798/GSCKStore'>here</a>
                <br><small>Reset you key <a href='API/regenKey.php'>here</a>. This deletes all your keys.</small>";
            }
            
        ?>
    </p><br>

    <table style="width:80%">
        <tr>
            <th>Key</th>
            <th>Value</th>
        </tr>
        <?php
            $sql = "SELECT * FROM `store` WHERE `SecretKey` = '".$row['SecretKey']."';";
            $result = mysqli_query($db,$sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".substr($row["keyValue"],0,strlen($row["keyValue"])-100)."</td><td>".$row["value"]."</td></tr>";
                }
            }
        ?>
    </table>
    <?php
        if($rank == 2){
            echo "<br><table style='width:100%'>
            <tr>
                <th>Email</th>
                <th>SecretKey</th>
                <th>Rank</th>
                <th>Key Regen</th>
                <th>Resend Confirmation</th>
            </tr>";
            $sql = "SELECT * FROM `users`;";
            $result = mysqli_query($db,$sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["Email"]."</td><td>".substr($row["SecretKey"],0,50)."...</td><td>".substr($row["Rank"],0,50)."</td><td><a href='API/regenKey.php?Email=". $row["Email"] ."'>Regen key</a><td><a href='API/resendConf.php?Email=". $row["Email"] ."'>Resend</a></td></tr>";
                }
            }
            echo "</table><br><br>";
        }
    ?>

    <small>
        This is in beta. Send me any bugs on discord at gsck#0874
    </small> <br>
    <a href = "signout.php">Sign Out</a>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>
