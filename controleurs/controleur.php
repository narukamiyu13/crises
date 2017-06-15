<?php
/* -------------------------------------
| fichier controleur.php
| -------------------------
| CONTRIBUTEURS
|   Auteur: Cédrick Collin
|   Modifications: Cédrick Collin
| -------------------------
| DATES
|   Création: 2 mai 2017
|   Dernière Modification: 12 mai 2017
| -------------------------
| DESCRIPTION
|   CONTROLEUR - Gère l'affichage des pages
|------------------------------------- */

require_once("modeles/modele.php");

class Controleur {
    /* -------------------------------------
    | constructeur
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   aucun
    | -------------------------
    | DESCRIPTION
    |   Initialise l'objet Controleur en lui assignant un objet modèle
    |------------------------------------- */   
    public function __construct(){
        $this->modele = new Modele();
       
    }
    
    /* -------------------------------------
    | FONCTION gererAffichage
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   aucun
    | -------------------------
    | DESCRIPTION
    |   Importe et affiche une vue selon la valeur de 'page' en GET
    |   Aucun lien ne mène vers index.php?page=XXX, c'est la réécriture d'URL qui s'en charge
    |   voir le fichier .htaccess 
    |------------------------------------- */  
    public function gererAffichage(){
        if(!isset($_GET['page'])) {
            require_once("vues/index.php");
        } else switch($_GET['page']) {
            case "lorganisme" : require_once("vues/lorganisme.php");break;
            case "historique" : require_once("vues/historique.php");break;
            case "philosophie" : require_once("vues/philosophie.php");break;
            case "services" : require_once("vues/services.php");break;
            case "admissibilite" : require_once("vues/admissibilite.php");break;
            case "definition" : require_once("vues/definition.php");break;
            case "devenirMembre" : require_once("vues/devenirMembre.php");break;
            case "devenirMembreSuite" : require_once("vues/devenirMembreSuite.php");break;
            case "don" : require_once("vues/don.php");break;
            case "emplois" : require_once("vues/emplois.php");break;
            case "evenements" : require_once("vues/evenements.php");break;
            case "bottin" : require_once("vues/bottin.php");break;
            case "documents" : require_once("vues/documents.php");break;
            case "contact" : require_once("vues/contact.php");break;
            case "renouveler" : require_once("vues/renouveler.php");break;
            case "renouvelerSuite" : require_once("vues/renouvelerSuite.php");break;
            case "temoignages" : require_once("vues/temoignages.php");break;
            default: require_once("vues/index.php");
        }
    }
    

    
    
}

?>