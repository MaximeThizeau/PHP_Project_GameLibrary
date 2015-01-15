<?php
	session_start();

	try
{
	$bdd = new PDO('mysql:host=localhost;dbname=php_project', 'root', 'root');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}


	if(isset($_SESSION['user-pseudo']))
	{
		$_SESSION['user-pseudo'] = $_SESSION['user-pseudo'];
	}

	else if(isset($_POST['ins-pseudo']) && isset($_POST['ins-password'])) // Ajouter une sécurité si il est déjà connecté
	{

	 	$pseudo_erreur = NULL;


	    $i = 0;
	    $pseudo = $_POST['ins-pseudo'];
	    $pass = $_POST['ins-password'];

	    $query = $bdd->prepare("SELECT COUNT(*) FROM Users WHERE pseudo = :pseudo");
	    $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
	    $query->execute();
	    $pseudo_free=($query->fetchColumn()==0)?1:0;
	    $query->CloseCursor();
	    if(!$pseudo_free)
	    {
		    $pseudo_erreur = 'Ce pseudo déjà utilisé.';
		    $i++;
	    }


	    if($i == 0)
	    {
		    echo '<h1> Inscription terminée </h1>';

			$query = $bdd->prepare("INSERT INTO Users (pseudo, password) VALUES (:pseudo, :password)");
			$query->bindValue(":pseudo", $_POST['ins-pseudo'], PDO::PARAM_STR);
			$query->bindValue(":password", $_POST['ins-password'], PDO::PARAM_STR);
			$query->execute();




		    $_SESSION['user-pseudo'] = $pseudo;
	        $_SESSION['user-id'] = $bdd->lastInsertId();
	        $_SESSION['user-password'] = $pass;


			$query->CloseCursor();

	    }
	    else
	    {
	        echo'<h1>Inscription interrompue</h1>';
	        echo'<p>Une ou plusieurs erreurs se sont produites pendant l incription</p>';
	        echo'<p>'.$i.' erreur(s)</p>';
	        echo'<p>'.$pseudo_erreur.'</p>';
	    }
	}

?>
