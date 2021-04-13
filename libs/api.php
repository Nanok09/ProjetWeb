<?php

use function PHPSTORM_META\map;

include_once "libUtils.php";
include_once "modele.php";
include_once "libValidation.php";
include_once "libMapbox.php";

session_start();

header("Access-Control-Allow-Origin: *"); // autoriser toutes les origines à faire des requêtes à notre api
header("Access-Control-Allow-Methods: *"); // autoriser tous les types de méthodes
header("Access-Control-Allow-Headers: *"); // autoriser tous les types de header

$data = array("version" => 1.1);

$method = $_SERVER["REQUEST_METHOD"];
//debug("method",$method);

if ($method == "OPTIONS") {
    die("ok - OPTIONS");
} // je sais pas si cette ligne est utile dans notre cas

$data["success"] = false;
$data["status"] = 400;

//==================   PARTIE VERIFICATION DE L'AUTORISATION (peut etre pas nécessaire)  =============================

//Vérifie si on est connecté, sinon on renvoie une erreur unauthorized
//A appeler pour chaque action qui nécessite d'être connecté

function verif_connecte()
{
    if (!valider("is_connected", "SESSION")) {
        $data["status"] = 403;
        return false;
    } else {
        return true;
    }
}

function set_request_success()
{
    global $data;
    $data["success"] = true;
    $data["status"] = 200;
}

// ===============

if ($action = valider("action")) {
    switch ($action) {
        case "add_note":
        case "modify_note":
            if (verif_connecte()) {
                if (($id_user = valider("id_user", "SESSION")) &&
                    ($id_lieu = valider("id_place")) &&
                    ($note = valider("note"))) {
                    if (is_valid_note($note)) {
                        add_note($id_user, $id_lieu, $note);
                        set_request_success();
                    }
                }
            }
            break;
        case "delete_note":
            if (verif_connecte()) {
                if (($id_user = valider("id_user", "SESSION")) &&
                    ($id_lieu = valider("id_place"))) {
                    $nb_modified = delete_note($id_lieu, $id_user);
                    if ($nb_modified > 0) {
                        set_request_success();
                    }
                }}
            break;
        case "add_comment":
            if (verif_connecte()) {
                if (($id_user = valider("id_user", "SESSION")) &&
                    ($id_lieu = valider("id_place")) &&
                    ($comment = valider("comment"))) {
                    $timestamp = date('Y-m-d H:i:s');
                    $data["data"] = array();
                    $data["data"]["timestamp"] = strtotime($timestamp);
                    $data["data"]["id_comment"] = add_comment($id_lieu, $id_user, $comment, $timestamp);
                    set_request_success();
                }
            }
            break;
        case "modify_comment":
            if (verif_connecte()) {
                if (($id_user = valider("id_user", "SESSION")) &&
                    ($id_comment = valider("id_comment")) &&
                    ($comment = valider("comment"))) {
                    $data["data"] = array();
                    $timestamp = date('Y-m-d H:i:s');
                    $data["data"]["timestamp"] = strtotime($timestamp);
                    $nb_modified = modify_comment($id_user, $id_comment, $comment, $timestamp);
                    if ($nb_modified > 0) {
                        set_request_success();
                    }
                }
            }
            break;
        case "delete_comment":
            if (verif_connecte()) {
                if (($id_user = valider("id_user", "SESSION")) &&
                    ($id_comment = valider("id_comment"))) {
                    $nb_modified = delete_comment($id_user, $id_comment);
                    if ($nb_modified > 0) {
                        set_request_success();
                    }
                }
            }
            break;
        case "add_creneau_dispo":
            if (verif_connecte()) {
                if (($id_user = valider("id_user", "SESSION")) &&
                    ($id_place = valider("id_place")) &&
                    ($date = valider("date")) &&
                    ($time_start = valider("time_start")) &&
                    ($time_end = valider("time_end")) &&
                    ($capacite = valider("capacite"))) {
                    if (get_createur_lieu($id_place) == $id_user &&
                        is_valid_date($date) &&
                        is_valid_time($time_start) &&
                        is_valid_time($time_end) &&
                        (strtotime($time_start) < strtotime($time_end))
                    ) {
                        $data["data"] = array();
                        $data["data"]["id_creneau"] = add_creneau_dispo($id_place, $date, $time_start, $time_end, $capacite);
                        set_request_success();
                    }
                }
            }
            break;
        case "add_reservation":
            if (verif_connecte()) {
                if (($id_user = valider("id_user", "SESSION")) &&
                    ($id_place = valider("id_place")) &&
                    ($date = valider("date")) &&
                    ($time_start = valider("time_start")) &&
                    ($time_end = valider("time_end")) &&
                    ($nb_personnes = valider("nb_personnes"))) {
                    if (is_valid_date($date) &&
                        is_valid_time($time_start) &&
                        is_valid_time($time_end) &&
                        (strtotime($time_start) < strtotime($time_end))
                    ) {
                        $capacite_restante = get_capacite_restante_creneau($id_place, $date, $time_start, $time_end);
                        if (intval($capacite_restante) >= intval($nb_personnes)) {
                            $data["data"] = array();
                            $data["data"]["id_reservation"] = add_reservation($id_user, $id_place, $date, $time_start, $time_end, $nb_personnes);
                            set_request_success();
                        } else {
                            $data["status"] = 200;
                        }
                    }
                }
            }
            break;
        case "delete_reservation":
            if (verif_connecte()) {
                if (($id_user = valider("id_user", "SESSION")) &&
                    ($id_reservation = valider("id_reservation"))) {
                    $nb_modified = delete_reservation($id_user, $id_reservation);
                    if ($nb_modified > 0) {
                        set_request_success();
                    }
                }
            }
            break;
        case "get_creneaux_place":
            if (($id_place = valider("id_place")) &&
                ($start = valider("start")) &&
                ($end = valider("end"))) {
                $date_start = date("Y-m-d", strtotime($start));
                $date_end = date("Y-m-d", strtotime($end));
                $creneaux = get_creneaux_lieu($id_place, $date_start, $date_end);
                $events = array();
                foreach ($creneaux as $creneau) {
                    $start = date("c", strtotime("$creneau[date] $creneau[time_start]"));
                    $end = date("c", strtotime("$creneau[date] $creneau[time_end]"));
                    $title = "$creneau[remaining_capacite] places restantes";
                    $class_name = "bg-success";
                    if (intval($creneau["remaining_capacite"]) == 0) {
                        $class_name = "bg-danger";
                    }
                    array_push($events, array("start" => $start, "end" => $end, "title" => $title, "className" => $class_name));
                }
                $data["data"] = $events;
                set_request_success();
            }
            break;
        case "get_capacite_creneau":
            if (($id_place = valider("id_place")) &&
                ($date = valider("date")) &&
                ($time_start = valider("time_start")) &&
                ($time_end = valider("time_end"))) {
                if (is_valid_date($date) &&
                    is_valid_time($time_start) &&
                    is_valid_time($time_end) &&
                    (strtotime($time_start) < strtotime($time_end))
                ) {
                    $data["data"] = array();
                    $data["data"]["capacite"] = get_capacite_restante_creneau($id_place, $date, $time_start, $time_end);
                    set_request_success();
                }
            }
            break;
        case "get_list_places":
            $arg_array = array(
                'sport' => false,
                'private_only' => false,
                'public_only' => false,
                'lat' => false,
                'long' => false,
                'price_min' => 0,
                'price_max' => 10000,
                'max_distance' => 1000,
                'max_results' => 10
            );
            if ($sport = valider('sport')) {
                $arg_array['sport'] = $sport;
            }
            if ($user_location_lat = valider("user_location_lat")) {
                // On prends toujours prioritairement la position envoyée par le client 
                $arg_array['lat'] = $user_location_lat;
            }
            if ($user_location_long = valider("user_location_long")) {
                // On prends toujours prioritairement la position envoyée par le client 

                $arg_array['long'] = $user_location_long;
            }
            if ($distance_max = valider("distance_max")) {
                $arg_array['max_distance'] = $distance_max;
            }
            if ($accept_public = valider("accept_public"))  {
                if ($accept_public === 'no') {
                    $arg_array['private_only'] = true;
                }
            }
            if ($accept_private = valider("accept_private")) {
                if ($accept_private === 'no') {
                    $arg_array['public_only'] = true;
                }
            }
            if ($prix_min = valider("prix_min")) {
                $arg_array['price_min'] = $prix_min;
            }
            if ($prix_max = valider("prix_max")) {
                $arg_array['price_max'] = $prix_max;
            }
            if ($max_results = valider("max_results")) {
                $arg_array['max_results'] = $max_results;
            }
            $results = get_places($arg_array['sport'],$arg_array['private_only'],$arg_array['public_only'],$arg_array['lat'],$arg_array['long'],$arg_array['price_min'],$arg_array['price_max'],$arg_array['max_distance'],$arg_array['max_results']);
            $data['data']=array();
            foreach ($results as $result) {
                $place_data = array();
                // modifier l'array obtenu pour être conforme à la doc 
                $place_data['id'] = $result['id'];
                $place_data['sport']=$result['sport'];
                $place_data['private'] = $result['prive'];
                $place_data['price'] = $result['prix'];
                $place_data['name'] = $result['nom'];
                $place_data['coordinates'] = array (
                    'lat' => $result['latitude'],
                    'long' => $result['longitude']
                );
                $place_data['address'] = $result['adresse'];
                $place_data['photos']=get_photos_place($result['id']);
                $place_data['note'] = get_note_place($result['id'])['mean'];
                if ($result['prive'] == 0) {
                    $place_data['dispo']=false;
                }
                if ($result['prive'] == 1) {
                    $place_data['dispo'] = $result['capacite']; // renseigner la capacité en temps réel 
                }
                $data['data'][]=$place_data;

            } // end foreach
            set_request_success();
            break;
        case 'get_place_info':
            if ($place_id = valider('terrain_id')){
                $result= get_place_info($place_id);
                $place_data = array();
                $place_data['id'] = $result['id'];
                $place_data['sport']=$result['sport'];
                $place_data['creator'] = $result['createur'];
                $place_data['private'] = $result['prive'];
                $place_data['price'] = $result['prix'];
                $place_data['name'] = $result['nom'];
                $place_data['coordinates'] = array (
                    'lat' => $result['latitude'],
                    'long' => $result['longitude']
                );
                $place_data['address'] = $result['adresse'];
                $place_data['photos']=get_photos_place($result['id']);
                $place_data['note'] = get_note_place($result['id']);
                if ($result['prive'] == 0) {
                    $place_data['dispo']=false;
                }
                if ($result['prive'] == 1) {
                    $place_data['dispo'] = $result['capacite']; // renseigner la capacité en temps réel 
                }
                $data['data'] = $place_data;
                set_request_success();
            }
            break;
        case 'address_research':
            $arg_array = array(
                'proximity' => array(),
                'distance_max' => 100,
                'max_results' => 10
            );
            if ($user_location_long = valider("user_location_long")) {
                // On prends toujours prioritairement la position envoyée par le client 
                $arg_array['proximity'][] = $user_location_long; // inversé par rapport à l'ordre habituel
            }
            if ($user_location_lat = valider("user_location_lat")) {
                // On prends toujours prioritairement la position envoyée par le client 
                $arg_array['proximity'][] = $user_location_lat; // inversé par rapport à l'ordre habituel
            }

            if ($distance_max = valider("distance_max")) {
                $arg_array['max_distance'] = $distance_max;
            }
            if ($max_results = valider("max_results")) {
                $arg_array['max_results'] = $max_results;
            }
            if ($address = valider('address')) { // on fait l'appel à l'api externe seulement si il y a un champ non vide
                // appel à l'api mapbox
                $arg_array['address'] = $address;
                //var_dump($arg_array);
                $data['data'] = address_research($arg_array['address'],$arg_array['proximity'],$arg_array['distance_max'],$arg_array['max_results']);
                set_request_success();
            }
            break;
    }
}

//============================= AJOUT DU RESPONSE HEADER CORRESPONDANT AU STATUS ET RENVOIS DE LA DONNE DEMANDEE===============

switch ($data["status"]) {
    case 200:header("HTTP/1.0 200 OK");
        break;
    case 201:header("HTTP/1.0 201 Created");
        break;
    case 202:header("HTTP/1.0 202 Accepted");
        break;
    case 204:header("HTTP/1.0 204 No Content");
        break;
    case 400:header("HTTP/1.0 400 Bad Request");
        break;
    case 401:header("HTTP/1.0 401 Unauthorized");
        break; // peu utilse pour nous a priori
    case 403:header("HTTP/1.0 403 Forbidden");
        break; // peu utilse pour nous a priori
    case 404:header("HTTP/1.0 404 Not Found");
        break;
    default:header("HTTP/1.0 200 OK");

}

echo json_encode($data);
