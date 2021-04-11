<?php
include_once "maLibUtils.php";
include_once "modele.php";

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
                    add_note($id_user, $id_lieu, $note);
                    set_request_success();
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
