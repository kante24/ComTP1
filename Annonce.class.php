
<?php
class Annonce
{
    private $_description;
    private $_date;
    private $_auteur;


    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    

    //definition des getters
    public function description()
    {
        return $this->_description;
    }
    public function date()
    {
        return $this->_date;
    }
    public function auteur()
    {
        return $this->_auteur;
    }



    //definition des setters
    public function setDescription($description)
    {
        $this->_description = $description;
    }
    public function setDate($date)
    {
        $this->_date = $date;
    }
    public function setAuteur($auteur)
    {
        $this->_auteur = $auteur;
    }


    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}
