<?php
require("Fonctions.class.php");
session_start();
if (!isset($_SESSION['connexion'])) {
    header('Location: Login.php');
    exit;
}
?>
    <!-- <Center>
    <h1>
        <U>
    Afficher les Annonce(s) publique(s)
</U>
    </h1>

</Center> -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Accueil Membre</title>
    </head>

    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">

                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link" target=_blank href="AccueilMembre.php">Accueil</a>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link" target=_blank href="LogOut.php">Déconnection</a>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link" target=_blank href="Publication.php">Publier une annonce</a>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link" target=_blank href="PublicationPrivee.php">Publier une annonce Privée</a>
                        </li>

                    </ul>

                </div>
            </div>
        </nav>

        <Center>
            <h1>
                <U>
            Accueil <?=$_SESSION['nom']?>
        </U>
            </h1>
        </Center>

        <div style="margin-top:100px;margin-left: 450px;">
            <form action="AccueilMembre.php" method="POST">
                <input type="submit" name="AnnoncesPubliques" value="Afficher les Annonces Publiques">
                <input style="margin-left: 100px;" type="submit" name="AnnoncesPrivees" value="Afficher les Annonces destinées à moi seul">
            </form>
        </div>


    </body>

    </html>


    <?php
    if (isset($_POST["AnnoncesPubliques"])) { AnnoncesPubliques(); }
    if (isset($_POST["AnnoncesPrivees"])) { AnnoncesPrive(); }
    ?>