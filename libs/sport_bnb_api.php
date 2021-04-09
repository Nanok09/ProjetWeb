<?php
include_once("libs/maLibUtils.php");
include_once("libs/modele.php");

header("Access-Control-Allow-Origin: *");// autoriser toutes les origines à faire des requêtes à notre api
header("Access-Control-Allow-Methods: *"); // autoriser tous les types de méthodes
header("Access-Control-Allow-Headers: *"); // autoriser tous les types de header 

$data = array("version"=>1.1);

// Routes : /api/...

$method = $_SERVER["REQUEST_METHOD"];
//debug("method",$method);

if ($method == "OPTIONS") die("ok - OPTIONS"); // je sais pas si cette ligne est utile dans notre cas


$data["success"] = false;
$data["status"] = 400; 


//==================   PARTIE VERIFICATION DE L'AUTORISATION (peut etre pas nécessaire)  =============================
//on utilise le même procédé que dans le cours pour le moment 

$connected = false; // par défaut on est pas connecté 


// recherche du hash : on cherche dans la requête et au besoin dans Server sinon on renvoie false:


if (!($hash = valider("hash",'GET'))) 
	$hash = valider("HTTP_HASH","SERVER"); 

// a cet instant la variable $hash est défini et vaut false si le hash n'a pas été trouvé. On vérifie si il est valide
// pour ce la on recherche dans la base de données si il existe un id associé à ce hash
if($hash) {
	// Il y a un hash, il doit être correct...
	if ($connectedId = hash2id($hash)) $connected = true;  //possible car hash2id utilise SQLgetchamps qui renvoie faux si pas de resultats

    //TO DO : Modifier le comportement de l'API dans le cas ou l'utilisateur n'est pas connecté, on a apriori juste besoin du token.. 
	else {
		// non connecté - peut-être est-ce POST vers /autenticate...
		$method = "error";// pas utile a priori 
		$data["status"] = 403;
	}
}



//============================ GENERATION DE LA DONNEE CORRESPONDANTE A L'URL DEMANDE ========================
/* on utilise la méthode GET à chaque fois pour les différentes actions
 */

//======================= LES DIFFERENTES ACTIONS =================

/* récupérer les plus proches terrains avec un parametre sport 


récupérer les terrains d'intérêt avec les en fonctions de l'historique ou de mentions j'aime ou qqch comme ça

récupérer toute l'information sur un terrain 

*/






//============================= AJOUT DU RESPONSE HEADER CORRESPONDANT AU STATUS ET RENVOIS DE LA DONNE DEMANDEE===============

switch($data["status"]) {
	case 200: header("HTTP/1.0 200 OK");	break;
	case 201: header("HTTP/1.0 201 Created");	break; 
	case 202: header("HTTP/1.0 202 Accepted");	break;
	case 204: header("HTTP/1.0 204 No Content");	break;
	case 400: header("HTTP/1.0 400 Bad Request");	break; 
	case 401: header("HTTP/1.0 401 Unauthorized");	break; // peu utilse pour nous a priori
	case 403: header("HTTP/1.0 403 Forbidden");	break; // peu utilse pour nous a priori
	case 404: header("HTTP/1.0 404 Not Found");		break;
	default: header("HTTP/1.0 200 OK");
		
}

echo json_encode($data);



