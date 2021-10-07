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
        if (empty($_POST['description']) or empty($_POST['date'])) {
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
        if (empty($_POST['description']) or empty($_POST['date']) or empty($_POST['login'])) {
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

function RechercheUser()
{
    if (isset($_POST["rechercheUser"])) {
        if (empty($_POST['login'])) {
            echo"<center>Veuillez remplir le champs de login SVP</center>";
        } else {
            $db = connexion();
            $UtilisateurManager = new UtilisateurManager($db);
            $results=$UtilisateurManager->rechercheUser($_POST["login"]);
            echo "</br></br></br>";
            foreach ($results as $key =>$value) {
                $Form = "";
                $Form .='<form action="adminUtilisateur.php" method="POST">';
                $Form .='<table>';
                $Form .='<tr>';
                $Form .='<td style="text-align: right;"><strong>Nom:</strong></td>';
                $Form .='<td style="text-align: left;">';
                $Form .='<input type="text" name="nom" value="' . $value->nom(). '" />';
                $Form .='</td>';
                $Form .='</tr>';
                $Form .='<tr>';
                $Form .='<td style="text-align: right;"><strong>Prenom:</strong></td>';
                $Form .='<td style="text-align: left;">';
                $Form .='<input type="text" name="prenom" value="' . $value->prenom(). '" />';
                $Form .='</td>';
                $Form .='</tr>';
                $Form .='<tr>';
                $Form .='<td style="text-align: right;"><strong>Âge:</strong></td>';
                $Form .='<td style="text-align: left;">';
                $Form .='<input type="text" name="age" value="' . $value->age(). '" />';
                $Form .='</td>';
                $Form .='</tr>';
                $Form .='<tr>';
                $Form .='<td style="text-align: center;">';
                $Form .='</br><input type="submit" name="modifierUser" value="Modifier"></td>';
                $Form .='<td style="text-align: center;">';
                $Form .='</br><input type="submit" name="supUser" value="Suprimer"></td>';
                $Form .='</tr>';
                $Form .='</table>';
                $Form .='</form>';
                echo $Form;
                $_SESSION["loginModife"] = $value->login() ;
            }
        }
    }
}

function ModifierUser()
{
    if (isset($_POST["modifierUser"])) {
        if (empty($_POST['prenom'])  or empty($_POST['nom']) or empty($_POST['age'])) {
            echo"<center>Veuillez remplir les champs SVP</center>";
        } else {
            $db = connexion();
            $Utilisateur=new Utilisateur_simple(array("nom"=>$_POST['nom'], "prenom"=>$_POST['prenom'], "age"=>$_POST['age'] ));
            $UtilisateurManager = new UtilisateurManager($db);
            $UtilisateurManager->modifierUser($Utilisateur);
            echo "<center>Modification réussie</center>";
        }
    }
}

function SuprimerUser()
{
    if (isset($_POST["supUser"])) {
        $db = connexion();
        $UtilisateurManager = new UtilisateurManager($db);
        $UtilisateurManager->suprimerUser();
        echo "<center>Suppression réussie</center>";
    }
}

function afficherAnnoncesAdmin()
{
    $db = connexion();
    $AnnonceManager = new AnnonceManager($db);
    $results=$AnnonceManager->afficherAnnonces();
    echo "</br></br></br>";
    foreach ($results as $key =>$value) {
        $Form = "";
        $Form .='<form action="adminAnnonce.php" method="POST">';
        $Form .='<table>';
        $Form .='<tr>';
        $Form .='<td style="text-align: right;"><strong>Description:</strong></td>';
        $Form .='<td style="text-align: left;">';
        $Form .='<textarea style="height: 100px;" name="description"/> ' . $value->description(). '</textarea> ';
        $Form .='</td>';
        $Form .='</tr>';
        $Form .='<tr>';
        $Form .='<td style="text-align: right;"><strong>Date:</strong></td>';
        $Form .='<td style="text-align: left;">';
        $Form .='<input type="text" name="date" value="' . $value->date(). '" />';
        $Form .='</td>';
        $Form .='</tr>';
        $Form .='<tr>';
        $Form .='<td style="text-align: right;"><strong>Auter:</strong></td>';
        $Form .='<td style="text-align: left;">';
        $Form .='<input type="text" name="auteur" value="' . $value->auteur(). '" />';
        $Form .='</td>';
        $Form .='</tr>';
        $Form .='<tr>';
        $Form .='<td style="text-align: center;">';
        $Form .='</br><input type="submit" name="modifierAnnonce" value="Modifier"></td>';
        $Form .='<td style="text-align: center;">';
        $Form .='</br><input type="submit" name="supAnnonce" value="Suprimer"></td>';
        $Form .='<td style="text-align: center;">';
        $Form .='</br><input type="hidden" name="id" value="' . $value->auteur(). '"></td>';
        $Form .='</tr>';
        $Form .='</table>';
        $Form .='</form>';
        $Form .='<hr></br></br></br>';
        echo $Form;
    }
}

function ModifierAnnonce()
{
    if (isset($_POST["modifierAnnonce"])) {
        if (empty($_POST['description'])  or empty($_POST['date']) or empty($_POST['auteur'])) {
            echo"<center>Veuillez remplir les champs SVP</center>";
        } else {
            $db = connexion();
            $annonce=new Annonce_publique(array("description"=>$_POST['description'], "date"=>$_POST['date'], "auteur"=>$_POST['auteur'] ));
            $AnnonceManager = new AnnonceManager($db);
            $AnnonceManager->modifierAnnonce($annonce);
            echo "<center>Modification réussie</center>";
        }
    }
}
