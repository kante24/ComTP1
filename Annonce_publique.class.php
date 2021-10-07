
<?php
class Annonce_publique extends Annonce
{
    private $_id;

    public function __construct(array $donnees)
    {
        parent::hydrate($donnees);
    }


    public function id()
    {
        return $this->_id;
    }



    //definition des setters
    public function setId($id)
    {
        $this->_id = $id;
    }
}
