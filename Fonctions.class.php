<?php
function chargerClasse($classe)
{
    require $classe . '.class.php';
}
spl_autoload_register('chargerClasse');


    //connexion pdo
function connexion()
{
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=TP1", "root", "");
        return $pdo;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function AnnoncesPubliques()
{
    //fin de la fonction connexion
    $db = connexion();
    $AnnonceManager = new AnnonceManager($db);
    $results=$AnnonceManager->afficherAnnonces();
    echo "</br></br></br>";
    foreach ($results as $key =>$value) {
        echo "<center></br></br>";
        echo "<table border = 1 style=width:500px;text-align:center;>";
        echo "<tr style=background-color:gainsboro> <td>Description</td>  <td>Date</td>  <td>Auteur</td></tr>";
        echo "<tr> <td>" . $value->description(). "</td>  <td>" . $value->date(). "</td>  <td>" . $value->auteur(). "</td></tr>";
        echo "</table>";
        echo "<hr/>";
        echo "</center>";
    }
}

function Annonces()
{
    //fin de la fonction connexion
    $db = connexion();
    $AnnonceManager = new AnnonceManager($db);
    $results=$AnnonceManager->afficherAdminAnnonces();
    echo "</br></br></br>";
    foreach ($results as $key =>$value) {
        echo "<center></br></br>";
        echo "<table border = 1 style=width:500px;text-align:center;>";
        echo "<tr style=background-color:gainsboro> <td>Description</td>  <td>Date</td>  <td>Auteur</td></tr>";
        echo "<tr> <td>" . $value->description(). "</td>  <td>" . $value->date(). "</td>  <td>" . $value->auteur(). "</td>  <td>" .  "</tr>";
        echo "</table>";
        echo "<hr/>";
        echo "</center>";
    }
}

function AnnoncesPrive()
{
    $db = connexion();
    $AnnonceManager = new AnnonceManager($db);
    $results=$AnnonceManager->afficherAnnoncesPrivees();
    echo "</br></br></br>";
    foreach ($results as $key =>$value) {
        echo "<center></br></br>";
        echo "<table border = 1 style=width:500px;text-align:center;>";
        echo "<tr style=background-color:gainsboro> <td>Description</td>  <td>Date</td>  <td>Auteur</td></tr>";
        echo "<tr> <td>" . $value->description(). "</td>  <td>" . $value->date(). "</td>  <td>" . $value->auteur(). "</td></tr>";
        echo "</table>";
        echo "<hr/>";
        echo "</center>";
    }
}

function Inscription()
{
    if (isset($_POST["Inscription"])) {
        if (empty($_POST['nom']) or empty($_POST['prenom']) or empty($_POST['age']) or empty($_POST['titre']) or empty($_POST['login']) or empty($_POST['password'])) {
            echo"<center>Veuillez remplir tous les champs SVP</center>";
        } else {
            $db = connexion();
            $Utilisateur=new Utilisateur_simple(array("nom"=>$_POST['nom'], "prenom"=>$_POST['prenom'], "age"=>$_POST['age'],  "titre"=>$_POST['titre'], "login"=>$_POST['login'], "password"=> $_POST['password']));
            $UtilisateurManager = new UtilisateurManager($db);
            $UtilisateurManager->inscription($Utilisateur);
            echo "<center>Inscription réussie, vous pouvez vous connecter</center>";
        }
    }
}

function LoginAmin()
{
    if (isset($_POST["ConnectionAdmin"])) {
        if (empty($_POST['login']) or empty($_POST['password'])) {
            echo"<center>Veuillez remplir tous les champs SVP</center>";
        } else {
            $db = connexion();
            $Utilisateur=new Admin(array("login"=>$_POST['login'],"password"=> $_POST['password']));
            $UtilisateurManager = new UtilisateurManager($db);
            $results=$UtilisateurManager->loginAdmin($Utilisateur);
    
            //test de contenu
            if ($results!== false) {
                session_start();
                $_SESSION['connexion'] = true;
                $_SESSION['nom'] = $_POST['login'];
                header("Location:AccueilAdmin.php");
            // echo $_SESSION['nom'];
            } else {
                echo"<center>Veuillez vous enregistrer</center>";
            }
        }
    }
}

function Login()
{
    if (isset($_POST["Connection"])) {
        if (empty($_POST['login']) or empty($_POST['password'])) {
            echo"<center>Veuillez remplir tous les champs SVP</center>";
        } else {
            $db = connexion();
            $Utilisateur=new Utilisateur_simple(array("login"=>$_POST['login'],"password"=> $_POST['password']));
            $UtilisateurManager = new UtilisateurManager($db);
            $results=$UtilisateurManager->login($Utilisateur);
    
            //test de contenu
            if ($results!== false) {
                session_start();
                $_SESSION['connexion'] = true;
                $_SESSION['nom'] = $_POST['login'];
                header("Location:AccueilMembre.php");
            } else {
                echo"<center>Veuillez vous enregistrer</center>";
            }
        }
    }
}

function rechercheID($login)
{
    $user = "root";
    $pwd = "";
    $host = "localhost";
    $bdd = "TP1";
    $link = mysqli_connect($host, $user, $pwd, $bdd) or die("Erreur de connexion au serveur!");
    $query = "SELECT * FROM Utilisateur Where login='" . $login . "';";
    $resultat = mysqli_query($link, $query) or die("Erreur dans la requête.");
    $Utilisateur = $resultat->fetch_assoc();

    $id = $Utilisateur["id"];
    return $id;
}

function publierAnnoncePublique()
{
    if (isset($_POST["publier"])) {
        if (empty($_POST['description']) or empty($_POST['date']) ) {
            echo"<center>Veuillez remplir tous les champs SVP</center>";
        } else {
            $db = connexion();
            $annonce=new Annonce_publique(array("description"=>$_POST['description'], "date"=>$_POST['date'], "auteur"=>$_SESSION["nom"] ));
            $AnnonceManager = new AnnonceManager($db);
            $AnnonceManager->creerAnnoncePublique($annonce);
            echo "<center>Annonce publiée</center>";
        }
    }
}

function publierAnnoncePrive()
{
    if (isset($_POST["publierPrive"])) {
        if (empty($_POST['description']) or empty($_POST['date']) or empty($_POST['login']) ) {
            echo"<center>Veuillez remplir tous les champs SVP</center>";
        } else {
            $db = connexion();
            $annonce=new Annonce_prive(array("description"=>$_POST['description'], "date"=>$_POST['date'], "auteur"=>$_SESSION["nom"] ));
            $AnnonceManager = new AnnonceManager($db);
            $AnnonceManager->creerAnnoncePrivee($annonce);
            echo "<center>Annonce publiée</center>";
        }
    }
}
