<?php
    include("config.php");
    
    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    $error = '';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $uEmail = mysqli_real_escape_string($db,$_POST['email']);
        $uPassw = hash('SHA256',mysqli_real_escape_string($db,$_POST['psword']));
        $uname = mysqli_real_escape_string($db,$_POST['username']);
        $sql = "SELECT * FROM `users` WHERE `Email` = '$uEmail';";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $rand = random_str(100);
        $count = mysqli_num_rows($result);

        // If result matched $myusername and $mypassword, table row must be 1 row

        if($count == 1) {
            $error = "Email is taken!";
        } else {
            $sql = "INSERT INTO `users` (`Username`,`Email`, `Password`, `SecretKey`, `Rank`) VALUES ('$uname','$uEmail', '$uPassw', '$rand', '0');";
            $result = mysqli_query($db,$sql);

            $headers = 'From: noreply@gsck.co.uk' . "\r\n" .
                'Reply-To: noreply@gsck.co.uk' . "\r\n" .
                'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                'X-Mailer: GSCKMailer';
                mail($uEmail, "GSCKStore Verification", "<h3>Verification</h3><br><p>Please click <a href='http://gsck.co.uk/dashboard/verify.php?key=$rand'>here</a> to verify your email.<br>Or copy this http://gsck.co.uk/dashboard/verify.php?key=$rand</p>
            ", $headers);

            header("location: login.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GSCK - Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        div.cent {
            width: 30%;
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
            <li class="nav-item">
                <a class="nav-link" href="/dashboard/login.php">Login</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/dashboard/signup.php">Sign up <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>

<div class="cent">
    <h1>Sign up</h1>
    <form action = "" method = "post">
        <div class="form-group">
            <label for="email">Username</label>
            <input type="text" class="form-control" name="username" aria-describedby="emailHelp" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" name="psword" placeholder="Password">
        </div>
        <button type="submit" id="sub" class="btn btn-primary">Submit</button>
        <small id="sub" class="form-text text-muted"><?php echo $error; ?></small>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>