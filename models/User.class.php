<?php

// Classe en cours de construction, l'inscription etla connexion n'étant pas terminée, ce fichier ne sert à rien pour l'instant. 

class User
{
	private $pseudo;
	private $lastname;
	private $firstname;

	public function __construct ()
    {
        if (func_num_args()> 0)
        {
            $this->pseudo = func_get_arg(0);
            $this->lastname =func_get_arg(1);
            $this->firstname = func_get_arg(2);
        }
        else
           echo "Il y a eu une erreur lors de la connexion.";
    }

}

?>
