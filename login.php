<?php 
// SOFIANE 20/01/2022 
       session_start();
    //setcookie('test',
    //         'testing', 
    //          [
    //           'expires' => time() + 3600,
    //           'secure' => true,
    //           'httponly'=> true,
    //          ]
    //        );
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Login</title>
    </head>
<body>
    <nav> 
        <a class="contact-admin" href="mailto:exemple@exemple.com">Contacter l'administrateur</a>
        <img class="headLogo logo" src="img\MenuizMan_logo.png" alt="logo">            
    </nav>
    <!-- // SOFIANE 20/01/2022 -->
    <div class="box-container">
        <div class="login-box">
        <form action="" method="POST">
            <fieldset class="login-fieldset">
                <legend class="login-legend">Connexion</legend>
                <!-- username   -->
                <label for="username" class="login-label">Username : </label>
                <input class="input-login" type="text" name="username" class="form-control" id="username" placeholder="Entrer votre email">     
                <!-- password  -->
                <label for="password" class="login-label">Password :</label>
                <input class="input-login" type="password" class="form-control" id="pwd" name="password" placeholder="Entrer votre mot de passe">
                <!-- submit -->
                <input type="submit" class="btn-login" value="Se connecter">
                <br>
                <small class="smallLogin">Ne partagez jamais vos identifiants de connexion.</small>
            </fieldset>
        </form>
    </div> 
    </div>
        <div class="box-container">
        <?php
    // SOFIANE 20/01/2022 
    // TO DO - PASSWORD CHECK (déjà préparé dans la classe);
    // enregistrement de l'username en session
            if (isset($_POST['username']) && isset($_POST['password'])) { 
                include "modules/classConnector.php";
                include "modules/ClassUser.php";
                $user = new User();
                // hash('sha256', $_POST['ppasscode'])
                $user->setUsername($_POST['username']);
                $user->setPassword($_POST['password']);
                $check = $user->checkName();
                $type = $user->returnType();
                if ($check == 1) {
                    $_SESSION['LOGGED_USER'] = $_POST['username'];
                    $_SESSION['password'] = $_POST['password'];
                    $_SESSION['allow'] = 'yes';
                    $type = $user->returnType();
                    $_SESSION['type_user'] = $type['typ_type'];
                    
                    header("Location: index.php");             
                } else {                        
                    print "<h4 class='btn btn-warning'> ERREUR, mauvais Login ou Password !</h4>";
                }
            } 
        ?>
        </div>
    <?php
    include "view/footer.php";
    ?>
</body>
</html>