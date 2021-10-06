<?php
require("Fonctions.class.php");
require("hautAdmin.php");
session_start();
if (!isset($_SESSION['connexion'])) {
    header('Location: Login.php');
    exit;
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Administration Annonces</title>
    </head>

    <body>

        <Center>
            <h1>
                <U>
                Administration des Annonces <?=$_SESSION['nom']?>
        </U>
            </h1>
        </Center>

        <div style="margin-top: 100px;margin-right: 50px;margin-left: 50px;">
            <div style="width:600px;float: left;border-right: 6px solid black;">
                <Center>
                    <h1 style="background-color: gainsboro;">
                        <U>
                    Annonce(s) publique(s)
                </U>
                    </h1>
                    <?php AnnoncesPubliques(); ?>
                </Center>
            </div>
        </div>


    </body>

    </html>