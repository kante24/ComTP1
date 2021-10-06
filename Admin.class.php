
<?php
class Admin extends Utilisateur
{
    public function __construct(array $donnees)
    {
        parent::hydrate($donnees);
    }
}