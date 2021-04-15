<?php
include_once("./libs/modele.php");

$id_user = $_SESSION['id_user'];
$destinataires = listerDestinataires($id_user);

$users = get_users();
?>