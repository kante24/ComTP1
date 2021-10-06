<?php

class AnnonceManager
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


    public function afficherAnnonces()
    {
        $req=$this->_db->query("SELECT * FROM Annonce_publique");
        $annonces= array();
        while ($data=$req->fetch(PDO::FETCH_ASSOC)) {
            $annonces[] = new Annonce_publique($data);
        }
        return $annonces;
    }
    public function creerAnnoncePublique(Annonce_publique $annonces)
    {
        $date = $annonces->date();
        $description =$annonces->description() ;
        $auteur = $annonces->auteur();
        $ins=$this->_db;
        $query = $ins->prepare("INSERT into Annonce_publique (description, date, auteur) VALUES ($description, $date, $auteur)");
        $query->execute() or die("<center>Erreur dans la requête</center>");
    }
    public function creerAnnoncePrivee(Annonce_prive $annonces)
    {
        $date = $annonces->date();
        $description =$annonces->description() ;
        $auteur = $annonces->auteur();
        $id = rechercheID($_POST["login"]);
        $ins=$this->_db;
        $query = $ins->prepare("INSERT INTO `Annonce_prive`(`description`, `date`, `auteur`, `destinataire`) VALUES ('$description','$date','$auteur', $id) ");
        $query->execute() or die("<center>Erreur dans la requête</center>");
    }

    public function afficherAnnoncesPrivees()
    {
        $req=$this->_db->query("SELECT Utilisateur.id, Utilisateur.login,Annonce_prive.description,Annonce_prive.date, Annonce_prive.auteur, Annonce_prive.destinataire FROM(Utilisateur INNER JOIN Annonce_prive ON Utilisateur.id = Annonce_prive.destinataire) WHERE Annonce_prive.destinataire = " . rechercheID($_SESSION["nom"]));
        $annonces= array();
        while ($data=$req->fetch(PDO::FETCH_ASSOC)) {
            $annonces[] = new Annonce_prive($data);
        }
        return $annonces;
    }

    public function afficherAdminAnnonces()
    {
        $req=$this->_db->query("SELECT * FROM Annonce_publique, Annonce_prive");
        $annonces= array();
        while ($data=$req->fetch(PDO::FETCH_ASSOC)) {
            $annonces[] = new Annonce_publique($data);
        }
        return $annonces;
    }
}