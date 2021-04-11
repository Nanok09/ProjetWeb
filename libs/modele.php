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
 * vériefie si il existe bien un utilisateur associé à l'id fourni dans la bdd
 * @param int id_user
 * @return bool id_user si l'utilsateur existe et false sinon
 */
function is_user($user_id) {
    $SQL= "SELECT id FROM utilisateurs WHERE id=?";
    $param=array($user_id);
    return SQLGetChamp($SQL,$param);
}

function get_place_creator($place_id) {
    $SQL= "SELECT createur FROM lieux WHERE id=?";
    $param= array($place_id);
    return SQLGetChamp($SQL,$param);
    
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




/**  fonction distance renvoie un float représentant la distance entre les points passés en entrée. La distance est donnée en km
 */


function distance($lat1, $lng1, $lat2, $lng2, $miles = false) {
     $pi80 = M_PI / 180;
     $lat1 *= $pi80;
     $lng1 *= $pi80;
     $lat2 *= $pi80;
     $lng2 *= $pi80;

     $r = 6372.797; // rayon moyen de la Terre en km
     $dlat = $lat2 - $lat1;
     $dlng = $lng2 - $lng1;
     $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin(
$dlng / 2) * sin($dlng / 2);
     $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
     $km = $r * $c;
     return ($miles ? ($km * 0.621371192) : $km);

}
/* Cette version ne marche pas j'ai oublié des conversions
function calculate_distance_between(array $a,array $b){
    // on utilise la formule de haversine
    $r= 6371;
    $first_term = (sin(($a['lat']-$b['lat'])/2))**2;
    $second_term = cos($a['lat'])*cos($b['lat'])*(sin(($a['long']-$b['long'])/2)**2);
    $result = 2*$r*asin(sqrt($first_term + $second_term));
    return $result;
}
*/
// fonction de comparaison pour le tri customisé
function compare($array1,$array2) {
    if ($array1['distance_to_user']>$array2['distance_to_user']) {
        return 1;
    }
    if ($array1['distance_to_user'] == $array2['distance_to_user']) {
        return 0;
    }
    return -1;    
}

/**
 * Récupérer les lieux les plus proches correspondant à certains critères
 * Tous les paramètres sont optionels
 * @param double lat
 * @param double long
 * @param string sport 
 * @param float price_min 
 * @param float price_max 
 * @param bool publuc_only
 * @param bool private_only
 * @param int max_distance (km)
 */




function get_places($sport = false , bool $private_only=false, bool $public_only=false,$lat= false , $long=false, int $price_min=0, int $price_max=10000, $max_distance=1000){

    // récupérer la liste des terrains potentielement intéressant dans la base de données

    $SQL = "SELECT * FROM lieux WHERE prix >= :price_min AND prix <= :price_max";

    $values = array(
        'price_min' => $price_min,
        'price_max' => $price_max,
    );

    if ($sport) {
        $SQL.= " AND sport=:sport";
        $values["sport"]=$sport;
    }

    if ($private_only && !$public_only) {
        $SQL.= " AND prive=:prive";
        $values["prive"] = 1; // si c'est que du private et pas du public alors on cherche les valeur prive=1
    }
    if ($public_only && !$private_only) {
        $SQL.=" AND prive=:prive";
        $values["prive"]=0;
    }

    if ($private_only && $public_only) {
        // raise error 'Warning : You are asking for private and public places, those are not supported in the current version'
        trigger_error("You are asking for private and public places, those does not exist in the current version",E_USER_WARNING );
    }



    //var_dump($values);

    $query_results = parcoursRs(SQLSelect($SQL , $values));

    //var_dump($result);

    // filtrer le résultat à l'aide de la fonction calculate distance between 

    if ($lat && $long) {
        echo 'on est dans la partie calculer les distances!';
        $final_results = array();
        foreach ( $query_results as $result) {
            $distance = distance($result['latitude'],$result['longitude'],$lat,$long);
            //var_dump($distance);
            if ($distance <= $max_distance)  {
                $result['distance_to_user'] = $distance;
                $final_results[] = $result;

            } // end if du foreach 
            

        }//end For each
        // trier les tableaux obtenus par distance à l'utilisateur croissante
        echo '<h2> Avant tri : </h2>';
        var_dump($final_results);
        usort($final_results,'compare'); // utilisation de la fonction usort qui permet de faire un tri customisé 
        return  $final_results;
        
    }//end if

    return $query_results;


    //renvoyer le résultat au bon format 

}//end Fonction







//Créer un lieu
/**
 * Fonction permettant de creer un lieu 
 * @param string nom
 * @param string description 
 * @param string adresse 
 * @param float lat
 * @param float long
 * @param string sport
 * @param int prive
 * @param int createur_id
 * @param float price
 * @param int capacite
 * @return int lastInsertedId
 */


function create_place(string $nom, string $description = '', string $adresse= '', float $lat, float $long, string $sport, int $private, int $createur_id, float $price=0, int $capacite = 10) {
    // il faut vérifier si le créateur_id correspond bien à un utilisateur. On pourait utiliser les variables de session comme paramètre par défaut..?
    

    
    if ($id_user = is_user($createur_id)) {

        $param = array(
            'nom' => $nom,
            'description' => $description,
            'adresse' => $adresse,
            'latitude' => $lat,
            'longitude' => $long,
            'sport' => $sport,
            'prive' => $private,
            'createur' => $createur_id,
            'prix' => $price,
            'capacite' => $capacite
        );
        $SQL= "INSERT INTO `lieux` (`nom`, `description`, `adresse`, `latitude`, `longitude`, `sport`, `prive`, `createur`, `prix`, `capacite`) VALUES
        ( :nom, :description, :adresse, :latitude, :longitude, :sport, :prive, :createur, :prix, :capacite)";
    
        return SQLInsert($SQL,$param);

    }//end if
    trigger_error("The given creator is not registered in the data base",E_USER_WARNING );
    return false;
}// end function




/** Modifier un lieu pour son créateur
 * @param int place_id
 * @param array modifications  un tablau associatif avec en clé les champs à modifier dans la bdd et en valeur les nouvelles valeurs à mettre
 * @return bool false or int nb_modifications: si l'utilisateur n'a pas le droit de modifier la place en question ou si il y a eu un pb pdt la requete, sinon renvoie le nombre de modifications 
*/


function modify_place(int $place_id, int $user_id, array $modifications) {
    

   // UPDATE commentaires SET message = :message, edited = true, timestamp=:timestamp WHERE idCommentaire = :id_comment AND idUtilisateur= :id_user"

    if ($user_id == get_place_creator($place_id)) { // vérifier que l'id correspond bien à un lieu dont l'utilisateur est le créateur
        $SQL= "UPDATE lieux SET";
        foreach ($modifications as $champ => $modification) {
            $SQL.= " $champ = :$champ, ";
        }
        $SQL = substr($SQL, 0, -2);
        $SQL.= " WHERE id=:id";
        var_dump($SQL);
        $modifications['id'] = $place_id;

        var_dump($modifications);
        return SQLUpdate($SQL,$modifications);
    }// end if
    
    trigger_error('The given user is not allowed to modify this place because it is not the place creator',E_USER_WARNING);
    return false;
}

//Récupérer les infos d'un lieu

/**
 * @param int place_id
 * @return array place_info
 */

function get_info(int $place_id) {

    $SQL= "SELECT * FROM lieux WHERE id=?";
    $param = array($place_id);
    $result = parcoursRs(SQLSelect($SQL,$param));
    return $result[0];
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
    $SQL = "UPDATE commentaires SET message = :message, edited = true, timestamp=:timestamp WHERE idCommentaire = :id_comment AND idUtilisateur= :id_user";
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
    return SQLSelect($SQL, $params);
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
