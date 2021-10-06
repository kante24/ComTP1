
<?php
class UtilisateurManager
{
    //retour de l'objet de connection pdo
    private $_db;

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function db()
    {
        $this->_db;
    }

    public function setDb($db)
    {
        return $this->_db = $db;
    }


    public function inscription(Utilisateur $utilisateur) //objet à inserer
    {
        $nom = $utilisateur->nom();
        $prenom =$utilisateur->prenom() ;
        $age = $utilisateur->age();
        $titre = $utilisateur->titre();
        $login =$utilisateur->login() ;
        $pass = $utilisateur->password();
        $ins=$this->_db;
        $query = $ins->prepare("INSERT into Utilisateur (nom, prenom, age, titre, login, password) VALUES ('$nom', '$prenom', '$age', '$titre', '$login', '$pass')");
        $query->execute() or die("<center>Erreur dans la requête</center>");
    }

    public function login(Utilisateur $utilisateur)
    {
        $login=$utilisateur->login();
        $password=$utilisateur->password();
        $req=$this->_db->query("SELECT * FROM Utilisateur WHERE login='".$login."' AND password='".$password."'");
        $data=$req->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            $objet = new Utilisateur($data);
            return $objet;
        } else {
            return false;
        }
    }

    public function loginAdmin(Utilisateur $utilisateur)
    {
        $login=$utilisateur->login();
        $password=$utilisateur->password();
        $req=$this->_db->query("SELECT * FROM Administrateur WHERE login='".$login."' AND password='".$password."'");
        $data=$req->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            $objet = new Utilisateur($data);
            return $objet;
        } else {
            return false;
        }
    }
}
