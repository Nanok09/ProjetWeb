<?php

include_once "maLibSQL.pdo.php";
include_once "libValidation.php";
// ============ UTILISATEURS ==============
/**
 * Vérifie si un utilisateur est bien dans la bdd
 * @param string $login
 * @param string $passe
 * @return string,int? id de l'utilisateur ou false
 */
function verif_user_bdd($login, $passe)
{
    $SQL = "SELECT id FROM utilisateurs WHERE pseudo=:login AND password=:passe;";
    $params = array("login" => $login, "passe" => $passe);
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
function create_user($pseudo, $password, $email, $nom, $prenom)
{
    $admin = '0';
    $SQL = "INSERT INTO utilisateurs (pseudo,password,nom,prenom,email,admin)";
    $SQL .= " VALUES (:pseudo,:password,:nom,:prenom,:email,:admin);";
    $params = array("pseudo" => $pseudo, "password" => $password, "nom" => $nom, "prenom" => $prenom, "email" => $email, "admin" => $admin);
    return SQLInsert($SQL, $params);
}

/**
 * Vérifie si un utilisateur est admin
 * @param int id_user
 * @return bool
 */
function is_admin($id_user)
{
    // vérifie si l'utilisateur est un administrateur
    $SQL = "SELECT admin from utilisateurs where id=?;";
    $params = array($id_user);
    return SQLGetChamp($SQL, $params);
}

/**
 * Modifie les infos d'un utilisateur
 * @param int id_user
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
 * @param int id_user
 * @param int id_place
 * @param int note (entre 1 et 5)
 */
function add_note($id_user, $id_place, $note)
{
    $SQL = "INSERT INTO notes (idLieu,idUtilisateur,note) VALUES (:id_place,:id_user,:note)";
    $SQL .= " ON DUPLICATE KEY UPDATE note = :note";
    $params = array("id_user" => $id_user, "id_place" => $id_place, "note" => $note);
    return SQLInsert($SQL, $params);
}

/**
 * Récupère la moyenne et le nombre de notes associées à un lieu
 * @param int id_place
 * @return Tableau_associatif
 * float note_moyenne
 * int nb_notes
 */
function get_note_place($id_place)
{
    $SQL = "SELECT avg(note) note_moyenne, count(note) nb_notes FROM notes WHERE idLieu = ?";
    $params = array($id_place);
    return SQLSelect($SQL, $params)[0];
}

/**
 * Supprime une note associée à un lieu
 * @param int  id_place
 * @param int id_user
 */
function delete_note($id_place, $id_user)
{
    $SQL = "DELETE FROM notes WHERE idLieu=:id_place, idUtilisateur=:id_user";
    $params = array("id_place" => $id_place, "id_user" => $id_user);
    return SQLDelete($SQL, $params);
}
// ============== COMMENTAIRES ================
/**
 * Ajouter un commentaire
 * @param int  id_place
 * @param int id_user
 * @param string message
 * @return int  id_comment
 */
function add_comment($id_place, $id_user, $message)
{
    $SQL = "INSERT INTO commentaires (idLieu,idUtilisateur,message) VALUES (:id_place,:id_user,:message)";
    $params = array("id_place" => $id_place, "id_user" => $id_user, "message" => $message);
    return SQLInsert($SQL, $params);
}
/**
 * Modifie un commentaire
 * @param int id_user
 * @param int idCommentaire
 * @param string message
 */

function modify_comment($id_user, $id_comment, $message)
{
    $SQL = "UPDATE commentaires SET message = :message, edited = true WHERE idCommentaire = :id_comment AND idUtilisateur= :id_user";
    $params = array("message" => $message, "id_comment" => $id_comment, "id_user" => $id_user);
    return SQLUpdate($SQL, $params);
}
/**
 * Récupère la liste des commentaires pour un lieu, ordonnés du plus récent au plus vieux
 * @TODO limiter le nb de commentaires récupérés ?
 * @param int id_place
 * @return liste de tableaux associatifs contenant les champs "nomUtilisateur", "id" (du commentaire), "message", "timestamp"
 */
function get_comments($id_place)
{
    $SQL = "SELECT u.nom nomUtilisateur, c.id, c.message, c.timestamp FROM commentaires as c INNER JOIN utilisateurs as u ON c.idUtilisateur=u.id";
    $SQL .= " WHERE c.idLieu = :id_place ORDER BY c.timestamp DESC";
    $params = array("id_place" => $id_place);
    return SQLSelect($SQL, $params);
}

// ============ PHOTOS LIEUX ============

//
/**
 * Ajouter une photo associée à un lieu (après l'avoir uploadé sur le serveur qq part)
 * @param int id_place
 * @param string nomFichier
 * @return int idPhoto
 */
function add_photo_place($id_place, $file_name)
{
    $SQL = "INSERT INTO photosLieux (idLieu,nomFichier) VALUES (:id_place,:file_name)";
    $params = array("id_place" => $id_place, "nomFichier" => $file_name);
    return SQLInsert($SQL, $params);
}
/**
 * Supprimer une photo (en vérifiant que le lieu associé à cette photo a bien été crée par $id_user)
 * @param int id_user
 * @param int idPhoto
 */
function delete_photo_place($id_user, $id_photo)
{
    $SQL = "DELETE FROM photosLieux p INNER JOIN lieux l ON p.idLieu = l.id WHERE p.id = :id_photo AND l.createur = :id_user";
    $params = array("id_photo" => $id_photo, "id_user" => $id_user);
    return SQLDelete($SQL, $params);
}
/**
 * Récupère les noms des fichiers des photos associés à un lieu
 * @param int id_place
 */
function get_photos_place($id_place)
{
    $SQL = "SELECT id,nomFichier FROM photosLieux WHERE idLieu=?";
    $params = array($id_place);
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
