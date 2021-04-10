<?php


include_once("maLibSQL.pdo.php");
// ============ UTILISATEURS ==============
/**
 * Vérifie si un utilisateur est bien dans la bdd
 * @param string $login
 * @param string $passe
 * @return string,int? id de l'utilisateur ou false
 */
function verifUserBdd($login, $passe)
{
    $SQL = "SELECT id FROM utilisateurs WHERE pseudo=:login AND password=:passe;";
    $params=array("login"=>$login,"passe"=>$passe);
    return SQLGetChamp($SQL, $params);
}

/**
 * Créé un nouvel utilisateur dans la bdd
 * @param string pseudo
 * @param string password
 * @param string email
 * @param string nom
 * @param string prenom
 * @return int id de l'utilisateur inséré ou false si erreur
 */
function createUser($pseudo, $password, $email, $nom, $prenom)
{
    $admin = '0';
    $SQL = "INSERT INTO utilisateurs (pseudo,password,nom,prenom,email,admin)";
    $SQL .=" VALUES (:pseudo,:password,:nom,:prenom,:email,:admin);";
    $params = array("pseudo"=>$pseudo,"password"=>$password,"nom"=>$nom,"prenom"=>$prenom,"email"=>$email,"admin"=>$admin);
    return SQLInsert($SQL, $params);
}

/**
 * Vérifie si un utilisateur est admin
 * @param int idUser
 * @return bool
 */
function isAdmin($idUser)
{
    // vérifie si l'utilisateur est un administrateur
    $SQL = "SELECT admin from utilisateurs where id=?;";
    $params=array($idUser);
    return SQLGetChamp($SQL, $params);
}

/**
 * Modifie les infos d'un utilisateur
 * @param int idUser
 * @param string password
 * @param string email
 * @param string nom
 * @param string prenom
 * @param
 */

// ================== LIEUX ===================

/**
 * Récupérer les lieux les plus proches correspondant à certains critères
 * @param double latitude
 * @param double longitude
 * @param string sport (optionel)
 * @param prix min / max
 */

//Créer un lieu

//Modifier un lieu pour son créateur

//Récupérer les infos d'un lieu


//// ================= NOTES =========================
/**
 * Ajoute une note à un lieu
 * @param int idUser
 * @param int idLieu
 * @param int note
 */
/**
 * Modifie la note attribuée à un lieu
 * @param int idUser
 * @param int idLieu
 * @param int note
 */
/**
 * Récupère la moyenne et le nombre de notes associées à un lieu
 * @param int idLieu
 * @return float moyenne
 * @return int nombre de notes
 */

// ============== COMMENTAIRES ================
/**
 * Ajouter un commentaire
 * @param int idLieu
 * @param int idUtilisateur
 * @param string message
 */
function ajouterCommentaire()
{
}
/**
 * Récupère la liste des commentaires pour un lieu
 * @param int idLieu
 *
 */
function getCommentaires()
{
}

// ============ CHAT ==========

//Envoyer un message

//Récupérer toutes les personnes avec qui quelqu'un a parlé

//Récupérer tous les messages entre 2 personnes

//Récupérer le dernier message "reçu" pour l'actualisation en ajax?

// ============= CRENEAUX ============

//Ajouter un créneau de disponibilité d'un lieu pour le créateur

//Modifier la capacité d'un créneau pour le créateur

// ============= RESERVATIONS ============

//Réserver un créneau

//Annuler un créneau réservé

// ============ PHOTOS LIEUX ============ 

//Ajouter une photo associée à un lieu (après l'avoir uploadé sur le serveur qq part)

//Supprimer une photo




//=============== FONCTIONS NECESSAIRES POUR L'API ==============================

function hash2id($hash) {
	$SQL = "SELECT id FROM users WHERE hash= :hash";        //modification pour fonctionner avec des requêtes préparées, voir modifications de SQLGetChamps
	return SQLGetChamp($SQL,array("hash" => $hash)); 
}