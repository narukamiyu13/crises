<?php
/* -------------------------------------
| fichier controleur.php
| -------------------------
| CONTRIBUTEURS
|   Auteur: Cédrick Collin
|   Modifications: Cédrick Collin
| -------------------------
| DATES
|   Création: 28 avril 2017
|   Dernière Modification: 1 juin 2017
| -------------------------
| DESCRIPTION
|   CONTROLEUR : gère l'affichage du panneau d'administration
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
    public function __construct() {
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
    |   Gère l'affichage du panneau d'administration en fonction de 
    |   1- Si l'utilisateur est connecté ou pas
    |   2- Si un tentative de connexion a été faite
    |   3- Si une erreur de connexion est faite
    |   4- S'il s'agit de la première connexion d'un utilisateur
    |   5- La valeur de la variable "page" passée en GET
    |------------------------------------- */  
    public function gererAdmin(){
        if(isset($_GET['logout'])){
        unset($_SESSION['prenom']);
        unset($_SESSION['userID']);
        unset($_SESSION['permission']);
        session_destroy();
        }
        
        if(isset($_GET['deleteAccount'])){
            $this->modele->deleteAdmin($_SESSION['userID']);
            unset($_SESSION['prenom']);
            unset($_SESSION['userID']);
            unset($_SESSION['permission']);
            session_destroy();
            
        }
        
        if(isset($_GET['premierLogin'])){
                require_once("vues/premiereConnexion.php");
            } else {
        
                if(isset($_SESSION['userID'])){
                    if(!isset($_GET['page'])){
                        require_once("vues/accueilDashboard.php");
                    } else { // if isset $_GET['page']
                        switch($_GET['page']){
                            case "gererAdmins" : require_once("vues/gererAdmins.php");break;
                            case "gererPassword" : require_once("vues/gererPassword.php");break;
                            case "gererParametres" : require_once("vues/gererParametres.php");break;
                            case "gererOuvertures" : require_once("vues/gererOuvertures.php");break;
                            case "gererContenu" : require_once("vues/gererContenu.php");break;
                            case "gererServices" : require_once("vues/gererServices.php");break;
                            case "gererTemoignages" : require_once("vues/gererTemoignages.php");break;
                            case "gererEvenements" : require_once("vues/gererEvenements.php");break;
                            case "gererHistorique" : require_once("vues/gererHistorique.php");break;
                            case "gererBottin" : require_once("vues/gererBottin.php");break;
                            case "gererAccueil" : require_once("vues/gererAccueil.php");break;
                            case "gererAdmissibilite" : require_once("vues/gererAdmissibilite.php");break;
                            case "gererOrganisme" : require_once("vues/gererOrganisme.php");break;
                            case "gererCategoriesBottin" : require_once("vues/gererCategoriesBottin.php");break;
                            case "gererPhilosophie" : require_once("vues/gererPhilosophie.php");break;
                            case "gererDefinition" : require_once("vues/gererDefinition.php");break;
                            case "gererDocuments" : require_once("vues/gererDocuments.php");break;
                            case "gererDons" : require_once("vues/gererDons.php");break;
                            case "gererEmplois" : require_once("vues/gererEmplois.php");break;
                            default: require_once("vues/accueilDashboard.php");
                        } // Fin SWITCH page
                    }
                } else { // if !isset $_SESSION['userID']
            
            
            
                if(!isset($_POST['connexion'])){
                    require_once("vues/index.php");
                } else {
                    if($this->modele->checkConnect($_POST['username'], $_POST['password'])){
                        if($this->modele->checkFirstTime($_POST['password'])) {
                            header("location:index.php?premierLogin");
                        } else {
                            require_once("vues/accueilDashboard.php");
                        }
                    } else {
                        $codeErreur = $this->modele->codeErreur($_POST['username'], $_POST['password']);
                        header("location:index.php?$codeErreur");
                    }
                }
            }
        }
    }
    
    
    
    
}

?>