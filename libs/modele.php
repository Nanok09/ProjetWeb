<?php


include_once("maLibSQL.pdo.php");

function verifUserBdd($login,$passe)
{
	$SQL = "SELECT id FROM utilisateurs WHERE pseudo='$login' AND password='$passe'";
	return SQLGetChamp($SQL);
}

function createUser($pseudo,$password,$email,$nom,$prenom){
	$date = date("Y-m-d H:i:s");
	$admin = '0';
	$SQL = "INSERT INTO utilisateurs (pseudo,password,nom,prenom,email,timeInscription,admin)";
    $SQL .=" VALUES ('$pseudo','$password','$nom','$prenom','$email','$date','$admin')";
	return SQLInsert($SQL);
}

function isAdmin($idUser)
{
	// vérifie si l'utilisateur est un administrateur
	$SQL = "SELECT admin from utilisateurs where id='$idUser'";
	return SQLGetChamp($SQL);
}

?>
