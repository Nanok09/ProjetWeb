<?php


include_once("maLibSQL.pdo.php");
include_once("libValidation.php");
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
 * Ajoute une note à un lieu (ou la modifie si elle existe déjà)
 * @param int idUser
 * @param int idLieu
 * @param int note (entre 1 et 5)
 */
function ajouterNote($idUser, $idLieu, $note)
{
    $SQL = "INSERT INTO notes (idLieu,idUtilisateur,note) VALUES (:idLieu,:utilisateur,:note)";
    $SQL .= " ON DUPLICATE KEY UPDATE note = :note";
    $params=array("note"=>$note);
    return SQLInsert($SQL, $params);
}


/**
 * Récupère la moyenne et le nombre de notes associées à un lieu
 * @param int idLieu
 * @return Tableau_associatif
 * float noteMoyenne
 * int nbNotes
 */
function getNoteLieu($idLieu)
{
    $SQL = "SELECT avg(note) noteMoyenne, count(note) nbNotes FROM notes WHERE idLieu = ?";
    $params = array($idLieu);
    return SQLSelect($SQL, $params)[0];
}


/**
 * Supprime une note associée à un lieu
 * @param int idLieu
 * @param int idUser
 */
function supprimerNote($idLieu, $idUser)
{
    $SQL = "DELETE FROM notes WHERE idLieu=:idLieu, idUtilisateur=:idUser";
    $params=array("idLieu"=>$idLieu,"idUser"=>$idUser);
    return SQLDelete($SQL, $params);
}
// ============== COMMENTAIRES ================
/**
 * Ajouter un commentaire
 * @param int idLieu
 * @param int idUtilisateur
 * @param string message
 * @return int idCommentaire
 */
function ajouterCommentaire($idLieu, $idUser, $message)
{
    $SQL = "INSERT INTO commentaires (idLieu,idUtilisateur,message) VALUES (:idLieu,:idUser,:message)";
    $params = array("idLieu"=>$idLieu,"idUser"=>$idUser,"message"=>$message);
    return SQLInsert($SQL, $params);
}
/**
 * Modifie un commentaire
 * @param int idCommentaire
 * @param string message
 */

 function modifierCommentaire($idComment, $message)
 {
     $SQL = "UPDATE commentaires SET message = :message WHERE idCommentaire = :idComment";
     $params=array("message"=>$message,"idComment"=>$idComment);
     return SQLUpdate($SQL, $params);
 }
/**
 * Récupère la liste des commentaires pour un lieu, ordonnés du plus récent au plus vieux
 * @TODO limiter le nb de commentaires récupérés ?
 * @param int idLieu
 * @return liste de tableaux associatifs contenant les champs "nomUtilisateur", "id" (du commentaire), "message", "timestamp"
 */
function getCommentaires($idLieu)
{
    $SQL = "SELECT u.nom nomUtilisateur, c.id, c.message, c.timestamp FROM commentaires as c INNER JOIN utilisateurs as u ON c.idUtilisateur=u.id";
    $SQL .= " WHERE c.idLieu = :idLieu ORDER BY c.timestamp DESC";
    $params=array("idLieu"=>$idLieu);
    return SQLSelect($SQL, $params);
}

// ============ PHOTOS LIEUX ============

//
/**
 * Ajouter une photo associée à un lieu (après l'avoir uploadé sur le serveur qq part)
 * @param int idLieu
 * @param string nomFichier
 * @return int idPhoto
 */
function ajouterPhotoLieu($idLieu, $nomFichier)
{
    $SQL = "INSERT INTO photosLieux (idLieu,nomFichier) VALUES (:idLieu,:nomFichier)";
    $params=array("idLieu"=>$idLieu,"nomFichier"=>$nomFichier);
    return SQLInsert($SQL, $params);
}
/**
 * Supprimer une photo (en vérifiant que le lieu associé à cette photo a bien été crée par $idUser)
 * @param int idUser
 * @param int idPhoto
 */
function supprimerPhotoLieu($idUser, $idPhoto)
{
    $SQL = "DELETE FROM photosLieux p INNER JOIN lieux l ON p.idLieu = l.id WHERE p.id = :idPhoto AND l.createur = :idUser";
    $params = array("idPhoto"=>$idPhoto,"idUser"=>$idUser);
    return SQLDelete($SQL, $params);
}
/**
 * Récupère les noms des fichiers des photos associés à un lieu
 * @param int idLieu
 */
function getPhotosLieu($idLieu)
{
    $SQL = "SELECT id,nomFichier FROM photosLieux WHERE idLieu=?";
    $params=array($idLieu);
    return SQLSelect($SQL, $params);
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
//=============== FONCTIONS NECESSAIRES POUR L'API ==============================

// function hash2id($hash)
// {
//     $SQL = "SELECT id FROM users WHERE hash= :hash";        //modification pour fonctionner avec des requêtes préparées, voir modifications de SQLGetChamps
//     return SQLGetChamp($SQL, array("hash" => $hash));
// }
