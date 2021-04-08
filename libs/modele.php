<?php


include_once("maLibSQL.pdo.php");

function verifUserBdd($login,$passe)
{
	$SQL = "SELECT id FROM utilisateurs WHERE pseudo='$login' AND password='$passe'";
	return SQLGetChamp($SQL);

	// Vérifie l'identité d'un utilisateur
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès


	// On utilise SQLGetChamp
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}

function isAdmin($idUser)
{
	// vérifie si l'utilisateur est un administrateur
	$SQL = "SELECT admin from utilisateurs where id='$idUser'";
	return SQLGetChamp($SQL);
}

?>
