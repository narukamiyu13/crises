<?php
/* -------------------------------------
| fichier index.php
| -------------------------
| CONTRIBUTEURS
|   Auteur: Cédrick Collin
|   Modifications: Cédrick Collin
| -------------------------
| DATES
|   Création: 2 mai 2017
|   Dernière Modification: 11 mai 2017
| -------------------------
| DESCRIPTION
|   FICHIER CENTRAL DU PROJET / Coté Client
|   Appelle le controleur afin de gérer quelle page
|   doit être affichée
|------------------------------------- */

require_once("controleurs/controleur.php");

$controleur = new Controleur();

$controleur->gererAffichage();

?>