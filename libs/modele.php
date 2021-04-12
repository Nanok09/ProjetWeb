<?php

include_once "libSQL.pdo.php";
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

/**
 * Modifier un terrain
 * @param int id_place
 * @param int id_user
 * @param string nom
 * @param string adresse
 * @param string sport
 * @param string description
 * @param int capacite
 * @param double prix
 */


/**
 * Créer un terrain
 * @param int id_place
 * @param int id_user
 * @param string nom
 * @param string adresse
 * @param string sport
 * @param string description
 * @param int capacite
 * @param double prix
 * @param boolean type(privé/public)
 */



//Récupérer les infos d'un lieu

/**
 * Récupère le créateur d'un lieu
 * @param int id_place
 */
function get_createur_lieu($id_place)
{
    $SQL = "SELECT createur FROM lieux WHERE id = :id_place";
    $params = array("id_place" => $id_place);
    return SQLGetChamp($SQL, $params);
}
/**
* Récupérer les lieux créés par un utilisateur
 * @param int id_user
 */

function get_places($id_user){
    $SQL = "SELECT * FROM lieux WHERE createur = ?";
    $params = array($id_user);
    return parcoursRs(SQLSelect($SQL, $params));

}

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
    return parcoursRs(SQLSelect($SQL, $params))[0];
}

/**
 * Supprime une note associée à un lieu
 * @param int  id_place
 * @param int id_user
 */
function delete_note($id_place, $id_user)
{
    $SQL = "DELETE FROM notes WHERE idLieu=:id_place AND idUtilisateur=:id_user";
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
function add_comment($id_place, $id_user, $message, $timestamp)
{
    $SQL = "INSERT INTO commentaires (idLieu,idUtilisateur,message,timestamp) VALUES (:id_place,:id_user,:message,:timestamp)";
    $params = array("id_place" => $id_place, "id_user" => $id_user, "message" => $message, "timestamp" => $timestamp);
    return SQLInsert($SQL, $params);
}
/**
 * Modifie un commentaire
 * @param int id_user
 * @param int id_comment
 * @param string message
 */

function modify_comment($id_user, $id_comment, $message, $timestamp)
{
    $SQL = "UPDATE commentaires SET message = :message, edited = true, timestamp=:timestamp WHERE id = :id_comment AND idUtilisateur= :id_user";
    $params = array("message" => $message, "id_comment" => $id_comment, "id_user" => $id_user, "timestamp" => $timestamp);
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
    return parcoursRs(SQLSelect($SQL, $params));
}
/**
 * Supprime un commentaire
 * @param int id_user
 * @param int id_comment
 */
function delete_comment($id_user, $id_comment)
{
    $SQL = "DELETE FROM commentaires WHERE idUtilisateur=:id_user AND id=:id_comment";
    $params = array("id_user" => $id_user, "id_comment" => $id_comment);
    return SQLDelete($SQL, $params);
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
    return parcoursRs(SQLSelect($SQL, $params));
}
/**
 * Récupère toutes les photos
 */
function get_photos()
{
    $SQL = "SELECT * FROM photosLieux";
    $params = array();
    return parcoursRs(SQLSelect($SQL,$params));
}

// ============ CHAT ==========

//Envoyer un message

//Récupérer toutes les personnes avec qui quelqu'un a parlé

//Récupérer tous les messages entre 2 personnes

//Récupérer le dernier message "reçu" pour l'actualisation en ajax?

// ============= CRENEAUX DISPONIBLES ============

//
/**
 * Ajouter un créneau de disponibilité d'un lieu pour le créateur
 * @pre verifier si id_user est le createur de id_place
 * @param int id_place
 * @param string date (jour sous la forme yyyy-mm-dd)
 * @param string heure_debut (hh:mm)
 * @param string heure_fin (hh:mm)
 * @param int capacite
 */
function add_creneau_dispo($id_place, $date, $heure_debut, $heure_fin, $capacite)
{
    $SQL = "INSERT INTO creneauxDispo (idLieu,date,heureDebut,heureFin,capacite) VALUES(:id_place,:date,:heure_debut,:heure_fin,:capacite);";
    $params = array("id_place" => $id_place, "date" => $date, "heure_debut" => $heure_debut, "heure_fin" => $heure_fin, "capacite" => $capacite);
    return SQLInsert($SQL, $params);
}

// ============= RESERVATIONS ============

/**
 * Réserver un créneau
 * pre vérifier qu'il y a au minimum nb_personnes en capacité restante sur le créneau ciblé
 * @param int id_user
 * @param int id_lieu
 * @param string date (yyyy-mm-dd)
 * @param string heure_debut (hh:mm)
 * @param string heure_fin (hh:mm)
 * @param int nb_personnes
 */
function add_reservation($id_user, $id_place, $date, $heure_debut, $heure_fin, $nb_personnes)
{
    $SQL = "INSERT INTO reservations (idUtilisateur,date,heureDebut,heureFin,nbPersonnes,idLieu) VALUES (:id_user,:date,:heure_debut,:heure_fin,:nb_personnes,:id_place);";
    $params = array("id_user" => $id_user, "date" => $date, "heure_debut" => $heure_debut, "heure_fin" => $heure_fin, "nb_personnes" => $nb_personnes, "id_place" => $id_place);
    return SQLInsert($SQL, $params);
}

/**
 * Annuler un créneau réservé
 * @param int id_user
 * @param int id_reservation
 */
function delete_reservation($id_user, $id_reservation)
{
    $SQL = "DELETE FROM reservations WHERE idUtilisateur = :id_user AND id = :id_reservation;";
    $params = array("id_user" => $id_user, "id_reservation" => $id_reservation);
    return SQLDelete($SQL, $params);
}

// ============== DISPONIBILITES ==================

//

/**
 * Récupère toutes les disponibilités d'un lieu entre deux dates (date_debut et fin incluses)
 * @param int id_place
 * @param string date_debut (yyyy-mm-dd)
 * @param string date_fin (yyyy-mm-dd)
 */
function get_creneaux_lieu($id_place, $date_debut, $date_fin)
{
    $condition = "WHERE t.idLieu = :id_place AND t.date >= :date_debut AND t.date <= :date_fin";
    $SQLExplode1 = "SELECT t.id as idCreneauDispo, t.idLieu, t.date, sum(t.capacite) as capacite, v.id as idCreneauHoraire, v.debut, v.fin FROM creneauxDispo as t LEFT JOIN creneauxValides as v ON t.heureDebut<=v.debut AND t.heureFin>=v.fin " . $condition . " GROUP BY date,idCreneauHoraire";
    $SQLExplode2 = "SELECT t.idLieu, t.date, sum(t.nbPersonnes) as nbPersonnes, v.id as idCreneauHoraire, v.debut, v.fin FROM reservations as t LEFT JOIN creneauxValides as v ON t.heureDebut<=v.debut AND t.heureFin>=v.fin " . $condition . " GROUP BY date,idCreneauHoraire";
    $SQL = "SELECT e1.date, e1.debut time_start, e1.fin time_end, e1.capacite, e2.nbPersonnes reservations, (e1.capacite - if(e2.nbPersonnes is null,0,e2.nbPersonnes)) as remaining_capacite FROM (" . $SQLExplode1 . ") as e1 LEFT JOIN (" . $SQLExplode2 . ") as e2 ON e1.idLieu = e2.idLieu AND e1.date = e2.date AND e1.idCreneauHoraire = e2.idCreneauHoraire;";
    $params = array("id_place" => $id_place, "date_debut" => $date_debut, "date_fin" => $date_fin);
    return parcoursRs(SQLSelect($SQL, $params));
}
/**
 * Récupère le nombre de places disponibles pour un lieu donné, un jour donné, entre heure_debut et heure_fin
 * @param int id_place
 * @param string date (yyyy-mm-dd)
 * @param string heure_debut (hh:mm)
 * @param string heure_fin (hh:mm)
 */
function get_capacite_restante_creneau($id_place, $date, $heure_debut, $heure_fin)
{
    $condition = "WHERE t.idLieu = :id_place AND t.date = :date";
    $SQLExplode1 = "SELECT t.id as idCreneauDispo, t.idLieu, t.date, sum(t.capacite) as capacite, v.id as idCreneauHoraire, v.debut, v.fin FROM creneauxDispo as t LEFT JOIN creneauxValides as v ON t.heureDebut<=v.debut AND t.heureFin>=v.fin " . $condition . " GROUP BY idCreneauHoraire";
    $SQLExplode2 = "SELECT t.idLieu, t.date, sum(t.nbPersonnes) as nbPersonnes, v.id as idCreneauHoraire, v.debut, v.fin FROM reservations as t LEFT JOIN creneauxValides as v ON t.heureDebut<=v.debut AND t.heureFin>=v.fin " . $condition . " GROUP BY idCreneauHoraire";
    $SQL = "SELECT min(if(capaciteRestante is null,0,capaciteRestante)) as capacite FROM creneauxValides v LEFT JOIN ";
    $SQL .= "(SELECT e1.idCreneauHoraire, (e1.capacite - if(e2.nbPersonnes is null,0,e2.nbPersonnes)) as capaciteRestante FROM (" . $SQLExplode1 . ") as e1 LEFT JOIN (" . $SQLExplode2 . ") as e2 ON e1.idLieu = e2.idLieu AND e1.date = e2.date AND e1.idCreneauHoraire = e2.idCreneauHoraire) calc ";
    $SQL .= "ON calc.idCreneauHoraire = v.id ";
    $SQL .= "WHERE v.debut>=:heure_debut AND v.fin <=:heure_fin";
    $params = array("id_place" => $id_place, "date" => $date, "heure_debut" => $heure_debut, "heure_fin" => $heure_fin);
    return SQLGetChamp($SQL, $params);
}
