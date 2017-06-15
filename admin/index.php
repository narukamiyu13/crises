<?php
/* -------------------------------------
| fichier index.php
| -------------------------
| CONTRIBUTEURS
|   Auteur: Cédrick Collin
|   Modifications: Cédrick Collin
| -------------------------
| DATES
|   Création: 28 avril 2017
|   Dernière Modification: 28 avril 2017
| -------------------------
| DESCRIPTION
|   FICHIER CENTRAL DU PROJET / Coté Administrateur
|   Appelle le controleur afin de gérer quelle page
|   doit être affichée
|------------------------------------- */
session_start();

require_once("controleur/controleur.php");

$controleur = new Controleur();
$controleur->gererAdmin();

?>