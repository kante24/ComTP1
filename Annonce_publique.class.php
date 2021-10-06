
<?php
class Annonce_publique extends Annonce
{
    public function __construct(array $donnees)
    {
        parent::hydrate($donnees);
    }
}
