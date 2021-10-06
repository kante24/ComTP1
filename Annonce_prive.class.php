
<?php
class Annonce_prive extends Annonce
{
    public function __construct(array $donnees)
    {
        parent::hydrate($donnees);
    }
}