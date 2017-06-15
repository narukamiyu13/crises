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
|   Dernière Modification: 1 juin 2017
| -------------------------
| DESCRIPTION
|   FICHIER CENTRAL DU PROJET / Coté Administrateur
|   Appelle le controleur afin de gérer quelle page
|   doit être affichée
|------------------------------------- */

class Modele {
    
    
    /* -------------------------------------
    | FONCTION connexionBD
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   $PDO : (Objet PDO) - Le résultat de la connexion à la BD
    | -------------------------
    | DESCRIPTION
    |   Effectue la connexion à la base de données
    |------------------------------------- */   
    public function connexionBD() {
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'");
        $PDO = new PDO("mysql:host=localhost;dbname=;charset=utf8", "", "", $options);
        return $PDO;
    }
    
    /* -------------------------------------
    | FONCTION checkConnect
    | -------------------------
    | PARAM
    |   $user: (STR) - le username entré par l'utilisateur
    |   $password: (STR) - le mot de passe entré par l'utilisateur
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si la connexion réussit, FALSE en cas d'erreur ou si la connexion échoue
    | -------------------------
    | DESCRIPTION
    |   Vérifie les informations entrées par l'utilisateur afin de tenter une connexion
    |------------------------------------- */   
    public function checkConnect($user, $password) {
        $password = sha1($password);
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM admins WHERE usernameAdmin=:username AND passwordAdmin=:password";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":username", $user, PDO::PARAM_STR);
        $PDOStatement->bindValue(":password", $password, PDO::PARAM_STR);
        $PDOStatement->execute();
        $resultat = $PDOStatement->fetch(PDO::FETCH_ASSOC);
        
        if($resultat['adminID']!= NULL) {
            $_SESSION['prenom'] = $resultat['prenomAdmin'];
            $_SESSION['userID'] = $resultat['adminID'];
            $_SESSION['permission'] = $resultat['permissionsAdmin'];
            $_SESSION['couleur'] = $resultat['themeAdmin'];
            return true;
        } else {
            return false;
        }
    }
    
    /* -------------------------------------
    | FONCTION checkFirstTime
    | -------------------------
    | PARAM
    |   $password: (STR) - Le mot de passe entré par l'utilisateur
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si c'est la première fois qu'un utilisateur se connecte, FALSE en cas d'erreur ou si ca n'est pas  la première connexion
    | -------------------------
    | DESCRIPTION
    |   Vérifie d'après le mot de passe s'il s'agit de la première fois qu'un utilisateur se connecte
    |------------------------------------- */   
    public function checkFirstTime($password) {
        $password = sha1($password);
        $PDO = $this->connexionBD();
        $query = "SELECT passwordAdmin FROM admins WHERE adminID=:adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":adminID", $_SESSION['userID'], PDO::PARAM_INT);
        $PDOStatement->execute();
        $resultat = $PDOStatement->fetch(PDO::FETCH_NUM);
        
        if($password == $resultat[0] && $password == sha1("123")){
            return true;
        } else {
            return false;
        }
    }
    
    /* -------------------------------------
    | FONCTION codeErreur
    | -------------------------
    | PARAM
    |   $user: (STR) - le username entré par l'utilisateur
    |   $password: (STR) - le mot de passe entré par l'utilisateur
    | -------------------------
    | RETURN
    |   $codeErreur: (STR) - le code d'erreur à utiliser
    | -------------------------
    | DESCRIPTION
    |   Génère un code d'erreur afin d'afficher les erreurs 
    |   d'authentification d'un utilisateur
    |------------------------------------- */   
    public function codeErreur($user, $password) {
        $codeErreur = "&err";
        if(!isset($user) || empty($user)) {
            $codeErreur .= "&8741";
        }
        if(!isset($password) || empty($password)) {
            $codeErreur .= "&1478";
        }
        if(isset($user) && !empty($user) && isset($password) && !empty($password)) {
            $codeErreur .= "&5284";
        }
        return $codeErreur;
    }
    
    /* -------------------------------------
    | FONCTION questionsSecurite
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste des questions de sécurité disponibles
    | -------------------------
    | DESCRIPTION
    |   Récupère la liste des questions de sécurité dans la BDD
    |------------------------------------- */   
    public function questionsSecurite() {
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM questionssecretes";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        
        
    }
    
    /* -------------------------------------
    | FONCTION updateInfos
    | -------------------------
    | PARAM
    |   $userID: (INT) - L'ID de l'utilisateur à mettre à jour
    |   $password: (STR) - Le mot de passe à utiliser pour la mise à jour
    |   $questions: (ARRAY) - Les questions de sécurité choisies par l'utilisateur
    |   $reponses: (ARRAY) - Les réponses aux questions de sécurité
    | -------------------------
    | RETURN
    |   aucun
    | -------------------------
    | DESCRIPTION
    |   Met à jour les informations de sécurité d'un utilisateur suite à sa première connexion
    |------------------------------------- */   
    public function updateInfos($userID, $password, $questions, $reponses) {
        $PDO = $this->connexionBD();
        $query = "UPDATE admins SET passwordAdmin=:password WHERE adminID=:adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":password", $password, PDO::PARAM_STR);
        $PDOStatement->bindValue(":adminID", $userID, PDO::PARAM_INT);
        $PDOStatement->execute();
        
        for($i = 0; $i < 3; $i++){
            $reponses[$i] = sha1(strtolower($reponses[$i]));
            $query = "INSERT INTO admin_a_questionsecrete (questionID, adminID, reponseQuestion) VALUES (:questionID, :adminID, :reponse)";
            $PDOStatement = $PDO->prepare($query);
            $PDOStatement->bindValue(":questionID", $questions[$i], PDO::PARAM_INT);
            $PDOStatement->bindValue(":adminID", $userID, PDO::PARAM_INT);
            $PDOStatement->bindValue(":reponse", $reponses[$i], PDO::PARAM_STR);
            $PDOStatement->execute();
         }
    }
    
    /* -------------------------------------
    | FONCTION getPermissionsAjoutAdmin
    | -------------------------
    | PARAM
    |   $actuel: (INT) - Le niveau de permissions de l'utilisateur
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste des niveaux de permissions disponibles
    | -------------------------
    | DESCRIPTION
    |   Récupère La liste des niveaux de permissions inférieurs ou égaux à
    |   celui de l'utilisateur
    |------------------------------------- */   
    public function getPermissionsAjoutAdmin($actuel){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM niveauxpermissions WHERE niveauPermissionID>=:actuel";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":actuel", $actuel, PDO::PARAM_INT);
        $PDOStatement->execute();
        $resultats = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        
        return $resultats;
    }
    
    
    /* -------------------------------------
    | FONCTION ajoutAdmin
    | -------------------------
    | PARAM
    |   $prenom: (STR) -  Le prénom
    |   $nom: (STR) - Le nom
    |   $username: (STR) - Le nom d'utilisateur
    |   $courriel: (STR) - L'adresse courriel
    |   $permissions: (INT) - Le niveau de permission à attribuer
    | -------------------------
    | RETURN
    |   aucun
    | -------------------------
    | DESCRIPTION
    |   Ajoute un administrateur dans la BDD
    |------------------------------------- */   
    public function ajoutAdmin($prenom, $nom, $username, $courriel, $niveauPermissions){
        $PDO = $this->connexionBD();
        $query = "INSERT INTO admins(prenomAdmin, nomAdmin, usernameAdmin, passwordAdmin, courrielAdmin, permissionsAdmin) VALUES (:prenom, :nom, :username, :password, :courriel, :permission)";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":prenom", $prenom, PDO::PARAM_STR);
        $PDOStatement->bindValue(":nom", $nom, PDO::PARAM_STR);
        $PDOStatement->bindValue(":username", $username, PDO::PARAM_STR);
        $PDOStatement->bindValue(":password", sha1("123"), PDO::PARAM_STR);
        $PDOStatement->bindValue(":courriel", $courriel, PDO::PARAM_STR);
        $PDOStatement->bindValue(":permission", $niveauPermissions, PDO::PARAM_INT);
        $PDOStatement->execute();
    }
    
    
    /* -------------------------------------
    | FONCTION getAdmins
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste des administrateurs avec un niveau de permissions plus bas que 
    |       celui de l'utilisateur
    | -------------------------
    | DESCRIPTION
    |   Récupère La liste des administrateurs avec un niveau de permissions plus bas que 
    |       celui de l'utilisateur
    |------------------------------------- */   
    public function getAdmins(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM admins INNER JOIN niveauxpermissions ON admins.permissionsAdmin = niveauxpermissions.niveauPermissionID WHERE permissionsAdmin>:permission";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":permission", $_SESSION['permission'], PDO::PARAM_INT);
        $PDOStatement->execute();
        $resultat = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }
    
    
    /* -------------------------------------
    | FONCTION deleteAdmin
    | -------------------------
    | PARAM
    |   $adminID: (INT) - L'ID de l'administrateur à supprimer
    | -------------------------
    | RETURN
    |   aucun
    | -------------------------
    | DESCRIPTION
    |   Supprime un administrateur
    |------------------------------------- */   
    public function deleteAdmin($adminID) {
        $PDO = $this->connexionBD();
        $query = "DELETE FROM admins WHERE adminID=:adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":adminID", $adminID, PDO::PARAM_INT);
        $PDOStatement->execute();
    }
    
    /* -------------------------------------
    | FONCTION getUnAdmin
    | -------------------------
    | PARAM
    |   $adminID: (INT) - L'ID de l'administrateur dont on veut les informations
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur l'administrateur demandé
    | -------------------------
    | DESCRIPTION
    |   Récupère Les informations sur un administrateur demandé
    |------------------------------------- */   
      public function getUnAdmin($adminID) {
        $PDO = $this->connexionBD();
        $query = "SELECT prenomAdmin,
                         nomAdmin, 
                         courrielAdmin, 
                         permissionsAdmin 
                  FROM admins 
                  WHERE adminID=:adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":adminID", $adminID, PDO::PARAM_INT);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION editAdmin
    | -------------------------
    | PARAM
    |   $prenom: (STR) -  Le nouveau prénom
    |   $nom: (STR) - Le nouveau nom
    |   $courriel: (STR) - La nouvelle adresse courriel
    |   $permissions: (INT) - Le niveau de permission à attribuer
    |   $adminID: (INT) - L'ID de l'administrateur à mettre à jour
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Met à jour les informations d'un administrateur
    |------------------------------------- */   
    public function editAdmin($prenom,$nom,$courriel,$permissions, $adminID) {
        try{
            $PDO = $this->connexionBD();
            $query = "UPDATE admins 
                        SET `prenomAdmin`=:prenom, 
                            `nomAdmin`=:nom, 
                            `courrielAdmin`=:courriel, 
                            `permissionsAdmin`=:permissions 
                        WHERE `adminID`=:adminID";
            $PDOStatement = $PDO->prepare($query);
            $PDOStatement->bindValue(":prenom",$prenom, PDO::PARAM_STR);
            $PDOStatement->bindValue(":nom",$nom, PDO::PARAM_STR);
            $PDOStatement->bindValue(":courriel",$courriel, PDO::PARAM_STR);
            $PDOStatement->bindValue(":permissions",$permissions, PDO::PARAM_INT);
            $PDOStatement->bindValue(":adminID",$adminID, PDO::PARAM_INT);
            return $PDOStatement->execute();
        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }
    
    /* -------------------------------------
    | FONCTION getPassword
    | -------------------------
    | PARAM
    |   $adminID: (INT) - L'ID de l'administrateur dont on veut le haché de mot de passe
    | -------------------------
    | RETURN
    |   (STR) - Le haché du mot de passe de l'administrateur demandé
    | -------------------------
    | DESCRIPTION
    |   Récupère Le haché du mot de passe d'un administrateur demandé
    |------------------------------------- */   
    public function getPassword($adminID){
        $PDO = $this->connexionBD();
        $query = "SELECT passwordAdmin
                  FROM admins
                  WHERE adminID=:adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":adminID", $adminID, PDO::PARAM_INT);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_NUM)[0];
    }
    

    /* -------------------------------------
    | FONCTION updatePassword
    | -------------------------
    | PARAM
    |   $password: (STR) - le mot de passe à utiliser pour la MAJ
    |   $adminID: (INT) -L'ID de l'administrateur qui met à jour son mot de passe
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Met à jour le mot de passe d'un administrateur
    |------------------------------------- */   
    public function updatePassword($password, $adminID){
        $password = sha1($password);
        $PDO = $this->connexionBD();
        $query = "UPDATE admins
                  SET passwordAdmin=:password
                  WHERE adminID=:adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":password",$password, PDO::PARAM_STR);
        $PDOStatement->bindValue(":adminID",$adminID, PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    
    /* -------------------------------------
    | FONCTION getParametres
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - Les paramètres actuels du site
    | -------------------------
    | DESCRIPTION
    |   Récupère les paramètres actuels du site dans la BDD
    |------------------------------------- */   
    public function getParametres(){
        $PDO = $this->connexionBD();
        $query = "SELECT *
                  FROM parametressite";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION updateParametres
    | -------------------------
    | PARAM
    |   $cotisationsIdentiques: (BOOL) - Détermine si les cotisations d'adhésion et
    |       de renouvellement sont identiques
    |   $creditPiedPage: (BOOL) - Détermine si le crédit au concepteur est ou non
    |       affiché dans le pied de page
    |   $cotisationAdhesion: (INT) - Montant de la cotisation d'adhésion
    |   $cotisationRenew: (INT) - Montant de la cotisation de renouvellement
    |   $couleurTheme: (STR) - Le code hexadécimal de la couleur à utiliser pour le thème
    |   $courrielAdjoint: (STR) - Courriel de l'adjoint-e administratif
    |   $courrielDirection: (STR) - Courriel du/de la directeur/trice
    |   $telephoneCrise: (STR) - Le numéro de téléphone qui affiche pour appeler en cas de crise
    |   $telephoneAdministration: (STR) - Le numéro de téléphone pour contacter l'administration
    |   $posteAdministration: (STR) - Le poste pour contacter l'administration (NULL POSSIBLE)
    |   $adresse: (STR) - L'adresse postale des bureaux administratifs
    |   $ville: (STR) - La ville où les bureaux administratifs sont situés
    |   $codePostal: (STR) - Le code postal des bureaux administratifs
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Effectue la connexion à la base de données
    |------------------------------------- */   
    public function updateParametres($cotisationsIdentiques,$creditPiedPage,$cotisationAdhesion,$cotisationRenew,$couleurTheme,$courrielAdjoint,$courrielDirection,$telephoneCrise,$telephoneAdministration,$posteAdministration,$adresse,$ville,$codePostal){
        $PDO = $this->connexionBD();
        $query = " UPDATE parametressite SET cotisationsIdentiques=:cotisationsIdentiques, coutCotisationAdhesion=:coutAdhesion, coutCotisationRenouvellement=:coutRenouvellement, courrielAdjoint=:courrielAdjoint, courrielDirection=:courrielDirection, telephoneCrise=:telephoneCrise, telephoneAdministration=:telephoneAdministration, posteAdministration=:posteAdministration, adresse=:adresse, ville=:ville, codePostal=:codePostal, creditFooter=:credit";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":cotisationsIdentiques", $cotisationsIdentiques, PDO::PARAM_INT);
        $PDOStatement->bindValue(":credit", $creditPiedPage, PDO::PARAM_INT);
        $PDOStatement->bindValue(":coutAdhesion", $cotisationAdhesion, PDO::PARAM_INT);
        $PDOStatement->bindValue(":coutRenouvellement", $cotisationRenew, PDO::PARAM_INT);
        $PDOStatement->bindValue(":courrielAdjoint", $courrielAdjoint, PDO::PARAM_INT);
        $PDOStatement->bindValue(":courrielDirection", $courrielDirection, PDO::PARAM_INT);
        $PDOStatement->bindValue(":telephoneCrise", $telephoneCrise, PDO::PARAM_INT);
        $PDOStatement->bindValue(":telephoneAdministration", $telephoneAdministration, PDO::PARAM_INT);
        $PDOStatement->bindValue(":posteAdministration", $posteAdministration, PDO::PARAM_INT);
        $PDOStatement->bindValue(":adresse", $adresse, PDO::PARAM_INT);
        $PDOStatement->bindValue(":ville", $ville, PDO::PARAM_INT);
        $PDOStatement->bindValue(":codePostal", $codePostal, PDO::PARAM_INT);
        $exec[] = $PDOStatement->execute();
        
        $this->updateCouleur($couleurTheme);
        return $exec;
    }
    
    /* -------------------------------------
    | FONCTION updateCouleur
    | -------------------------
    | PARAM
    |   $couleurTheme: (STR) - Le code hexadécimal à utiliser pour le remplacement
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Met à jour le thème du panneau d'administration d'un utilisateur
    |------------------------------------- */   
    public function updateCouleur($couleurTheme){
        $PDO = $this->connexionBD();
        $query = "UPDATE admins SET themeAdmin=:theme WHERE adminID=:adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":theme", $couleurTheme, PDO::PARAM_STR);
        $PDOStatement->bindValue(":adminID", $_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    /* -------------------------------------
    | FONCTION getBoutons
    | -------------------------
    | PARAM
    |   $niveauPermission: (INT) - Le niveau de permissions d'un utilisateur
    | -------------------------
    | RETURN
    |   (ARRAY) - Les boutons accessibles
    | -------------------------
    | DESCRIPTION
    |   Récupère la liste des boutons d'administration accessibles par un utilisateur
    |------------------------------------- */   
     public function getBoutons($niveauPermission){
        $PDO = $this->connexionBD();
        $query = "SELECT texteBtn, urlBtn
                FROM btngestion
                WHERE permRequis>=:niveauPermission";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":niveauPermission", $niveauPermission, PDO::PARAM_INT);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_NUM);
    }
    
    
    /* -------------------------------------
    | FONCTION getTexteServices
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur le texte et sa dernière modification
    | -------------------------
    | DESCRIPTION
    |   Récupère le texte actuel de la page "Services" dans la BDD
    |------------------------------------- */   
    public function getTexteServices(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM contenuservices INNER JOIN admins ON contenuservices.modificateurID = admins.adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION setTexteServices
    | -------------------------
    | PARAM
    |   $texte: (STR) - Le texte à utiliser pour le remplacement
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Met à jour le texte de la page "Services"
    |------------------------------------- */   
     public function setTexteServices($texte){
        $PDO = $this->connexionBD();
        $query = "UPDATE contenuservices SET texteServices=:texte, derniereModification=NOW(), modificateurID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":texte",$texte, PDO::PARAM_STR);
        $PDOStatement->bindValue(":id",$_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
       
    }
    
    
    /* -------------------------------------
    | FONCTION getTexteAccueil
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur le texte et sa dernière modification
    | -------------------------
    | DESCRIPTION
    |   Récupère le texte actuel de la page "Accueil" dans la BDD
    |------------------------------------- */   
     public function getTexteAccueil(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM contenuaccueil INNER JOIN admins ON contenuaccueil.modificateurID = admins.adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    /* -------------------------------------
    | FONCTION setTexteAccueil
    | -------------------------
    | PARAM
    |   $texte: (STR) - Le texte à utiliser pour le remplacement
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Met à jour le texte de la page "Accueil"
    |------------------------------------- */   
     public function setTexteAccueil($texte){
        $PDO = $this->connexionBD();
        $query = "UPDATE contenuaccueil SET texteAccueil=:texte, derniereModification=NOW(), modificateurID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":texte",$texte, PDO::PARAM_STR);
        $PDOStatement->bindValue(":id",$_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
       
    }
    
    /* -------------------------------------
    | FONCTION getTexteAdmissibilite
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur le texte et sa dernière modification
    | -------------------------
    | DESCRIPTION
    |   Récupère le texte actuel de la page "Admissibilité" dans la BDD
    |------------------------------------- */   
    public function getTexteAdmissibilite(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM contenuadmissibilite INNER JOIN admins ON contenuadmissibilite.modificateurID = admins.adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    /* -------------------------------------
    | FONCTION setTexteAdmissibilite
    | -------------------------
    | PARAM
    |   $texte: (STR) - Le texte à utiliser pour le remplacement
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Met à jour le texte de la page "Admissibilité"
    |------------------------------------- */   
    public function setTexteAdmissibilite($texte){
        $PDO = $this->connexionBD();
        $query = "UPDATE contenuadmissibilite SET texteAdmissibilite=:texte, derniereModification=NOW(), modificateurID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":texte",$texte, PDO::PARAM_STR);
        $PDOStatement->bindValue(":id",$_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    /* -------------------------------------
    | FONCTION getTexteEmploi
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur le texte et sa dernière modification
    | -------------------------
    | DESCRIPTION
    |   Récupère le texte actuel de la page "Emplois" dans la BDD
    |------------------------------------- */   
    public function getTexteEmploi(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM contenuEmplois INNER JOIN admins ON contenuEmplois.modificateurID = admins.adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    /* -------------------------------------
    | FONCTION setTexteEmploi
    | -------------------------
    | PARAM
    |   $texte: (STR) - Le texte à utiliser pour le remplacement
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Met à jour le texte de la page "Emplois"
    |------------------------------------- */   
    public function setTexteEmploi($texte){
        $PDO = $this->connexionBD();
        $query = "UPDATE contenuEmplois SET texteEmplois=:texte, derniereModification=NOW(), modificateurID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":texte",$texte, PDO::PARAM_STR);
        $PDOStatement->bindValue(":id",$_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    
     /* -------------------------------------
    | FONCTION getTexteOrganisme
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur le texte et sa dernière modification
    | -------------------------
    | DESCRIPTION
    |   Récupère le texte actuel de la page "L'Organisme" dans la BDD
    |------------------------------------- */   
    public function getTexteOrganisme(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM contenulorganisme INNER JOIN admins ON contenulorganisme.modificateurID = admins.adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    /* -------------------------------------
    | FONCTION setTexteOrganisme
    | -------------------------
    | PARAM
    |   $texte: (STR) - Le texte à utiliser pour le remplacement
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Met à jour le texte de la page "L'Organisme"
    |------------------------------------- */   
    public function setTexteOrganisme($texte){
        $PDO = $this->connexionBD();
        $query = "UPDATE contenulorganisme SET texteLorganisme=:texte, derniereModification=NOW(), modificateurID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":texte",$texte, PDO::PARAM_STR);
        $PDOStatement->bindValue(":id",$_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    
    
     /* -------------------------------------
    | FONCTION getTextePhilosophie
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur le texte et sa dernière modification
    | -------------------------
    | DESCRIPTION
    |   Récupère le texte actuel de la page "Philosophie" dans la BDD
    |------------------------------------- */   
    public function getTextePhilosophie(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM contenuphilosophie INNER JOIN admins ON contenuphilosophie.modificateurID = admins.adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    /* -------------------------------------
    | FONCTION setTextePhilosophie
    | -------------------------
    | PARAM
    |   $texte: (STR) - Le texte à utiliser pour le remplacement
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Met à jour le texte de la page "Philosophie"
    |------------------------------------- */   
    public function setTextePhilosophie($texte){
        $PDO = $this->connexionBD();
        $query = "UPDATE contenuphilosophie SET textePhilosophie=:texte, derniereModification=NOW(), modificateurID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":texte",$texte, PDO::PARAM_STR);
        $PDOStatement->bindValue(":id",$_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    
    
     /* -------------------------------------
    | FONCTION getTexteDefinition
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur le texte et sa dernière modification
    | -------------------------
    | DESCRIPTION
    |   Récupère le texte actuel de la page "Définition d'une crise" dans la BDD
    |------------------------------------- */   
    public function getTexteDefinition(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM contenudefinition INNER JOIN admins ON contenudefinition.modificateurID = admins.adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    /* -------------------------------------
    | FONCTION setTexteDefinition
    | -------------------------
    | PARAM
    |   $texte: (STR) - Le texte à utiliser pour le remplacement
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Met à jour le texte de la page "Définition d'une crise"
    |------------------------------------- */   
    public function setTexteDefinition($texte){
        $PDO = $this->connexionBD();
        $query = "UPDATE contenudefinition SET texteDefinition=:texte, derniereModification=NOW(), modificateurID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":texte",$texte, PDO::PARAM_STR);
        $PDOStatement->bindValue(":id",$_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    
    /* -------------------------------------
    | FONCTION getTexteDons
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur le texte et sa dernière modification
    | -------------------------
    | DESCRIPTION
    |   Récupère le texte actuel de la page "Faire un don" dans la BDD
    |------------------------------------- */   
    public function getTexteDons(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM contenuDons INNER JOIN admins ON contenuDons.modificateurID = admins.adminID";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    /* -------------------------------------
    | FONCTION setTexteDon
    | -------------------------
    | PARAM
    |   $texte: (STR) - Le texte à utiliser pour le remplacement
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Met à jour le texte de la page "Faire un Don"
    |------------------------------------- */   
    public function setTexteDons($texte){
        $PDO = $this->connexionBD();
        $query = "UPDATE contenuDons SET texteDons=:texte, derniereModification=NOW(), modificateurID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":texte",$texte, PDO::PARAM_STR);
        $PDOStatement->bindValue(":id",$_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    /* -------------------------------------
    | FONCTION getTemoignages
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |  (ARRAY) - La liste des témoignages dans la BDD
    | -------------------------
    | DESCRIPTION
    |   Récupère la liste des témoignages dans la BDD
    |------------------------------------- */   
    public function getTemoignages(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM temoignages";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /* -------------------------------------
    | FONCTION getTemoignage
    | -------------------------
    | PARAM
    |   $id: (INT) - L'ID du témoignage à récupérer
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur le témoignage voulu
    | -------------------------
    | DESCRIPTION
    |   Récupère les informations sur un témoignage dans la BDD
    |------------------------------------- */   
    public function getTemoignage($id){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM temoignages WHERE temoignageID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION editTemoignage
    | -------------------------
    | PARAM
    |   $temoin: (STR) - Le nom du témoin
    |   $temoignage: (STR) - Le témoignage
    |   $temoignageID: (INT) - L'ID du témoignage à modifier
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Modifie un témoignage dans la BDD
    |------------------------------------- */   
    public function editTemoignage($temoin, $temoignage, $temoignageID){
        $PDO = $this->connexionBD();
        $query = "UPDATE temoignages SET temoigneur=:temoin, texteTemoignage=:temoignage WHERE temoignageID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":temoin", $temoin, PDO::PARAM_INT);
        $PDOStatement->bindValue(":temoignage", $temoignage, PDO::PARAM_INT);
        $PDOStatement->bindValue(":id", $temoignageID, PDO::PARAM_INT);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    /* -------------------------------------
    | FONCTION ajoutTemoignage
    | -------------------------
    | PARAM
    |   $temoin: (STR) - Le nom du témoin
    |   $temoignage: (STR) - Le témoignage
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Ajoute un témoignage dans la BDD
    |------------------------------------- */   
    public function ajoutTemoignage($temoin, $temoignage){
        $PDO = $this->connexionBD();
        $query = "INSERT INTO temoignages (temoigneur, texteTemoignage, modificateurID) VALUES (:temoin, :temoignage, :modificateur)";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":temoin", $temoin, PDO::PARAM_INT);
        $PDOStatement->bindValue(":temoignage", $temoignage, PDO::PARAM_INT);
        $PDOStatement->bindValue(":modificateur", $_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    
    /* -------------------------------------
    | FONCTION deleteTemoignage
    | -------------------------
    | PARAM
    |   $id: (INT) - Le ID du témoignage à supprimer
    | -------------------------
    | RETURN
    |   aucun
    | -------------------------
    | DESCRIPTION
    |   Supprime un témoignage de la BDD
    |------------------------------------- */   
     public function deleteTemoignage($id) {
        $PDO = $this->connexionBD();
        $query = "DELETE FROM temoignages WHERE temoignageID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $PDOStatement->execute();
    }
    
    /* -------------------------------------
    | FONCTION getEvenements
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste des événements dans la BDD
    | -------------------------
    | DESCRIPTION
    |   Récupère La liste des événements dans la BDD
    |------------------------------------- */   
    public function getEvenements(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM evenements";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION getEvenement
    | -------------------------
    | PARAM
    |   $id: (INT) - Le ID de l'événement dont on veut les informations
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur l'événement récupéré
    | -------------------------
    | DESCRIPTION
    |   Récupère les informations d'un événement
    |------------------------------------- */   
    public function getEvenement($id){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM evenements WHERE evenementID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION editEvenement
    | -------------------------
    | PARAM
    |   $nom: (STR) - Le nom de l'événement à ajouter
    |   $date: (DATETIME) - La date et l'heure de l'événement à modifier
    |   $description: (STR) - La description de l'événement à modifier
    |   $evenementID: (INT) - L'ID de l'événement à modifier
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Modifie un événement dans la BDD
    |------------------------------------- */   
    public function editEvenement($nom, $date, $description, $evenementID){
        $PDO = $this->connexionBD();
        $query = "UPDATE evenements SET nomEvenement=:nom, dateEvenement=:date, descriptionEvenement=:description WHERE evenementID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":nom", $nom, PDO::PARAM_INT);
        $PDOStatement->bindValue(":date", $date, PDO::PARAM_INT);
        $PDOStatement->bindValue(":description", $description, PDO::PARAM_INT);
        $PDOStatement->bindValue(":id", $evenementID, PDO::PARAM_INT);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION ajoutEvenement
    | -------------------------
    | PARAM
    |   $nom: (STR) - Le nom de l'événement à ajouter
    |   $date: (DATETIME) - La date et l'heure de l'événement à ajouter
    |   $description: (STR) - La description de l'événement à ajouter
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Ajoute un événement dans la BDD
    |------------------------------------- */   
    public function ajoutEvenement($nom, $date, $description){
        $PDO = $this->connexionBD();
        $query = "INSERT INTO evenements SET nomEvenement=:nom, dateEvenement=:date, descriptionEvenement=:description, modificateurID=:modificateur";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":nom", $nom, PDO::PARAM_INT);
        $PDOStatement->bindValue(":date", $date, PDO::PARAM_INT);
        $PDOStatement->bindValue(":description", $description, PDO::PARAM_INT);
        $PDOStatement->bindValue(":modificateur", $_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    
    /* -------------------------------------
    | FONCTION deleteEvenement
    | -------------------------
    | PARAM
    |   $id: (INT) - L'ID de l'événement à supprimer
    | -------------------------
    | RETURN
    |   aucun
    | -------------------------
    | DESCRIPTION
    |   Supprime un événement historique de la BDD
    |------------------------------------- */   
     public function deleteEvenement($id) {
        $PDO = $this->connexionBD();
        $query = "DELETE FROM evenements WHERE evenementID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $PDOStatement->execute();
    }
    
    
    
     /* -------------------------------------
    | FONCTION getHistoriques
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste des événements historiques dans la BDD
    | -------------------------
    | DESCRIPTION
    |   Récupère tous les événements historiques dans la BDD
    |------------------------------------- */   
    public function getHistoriques(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM historique 
        ORDER BY anneeEvenementHistorique ASC,
            CASE moisEvenementHistorique
            WHEN 'Janvier' THEN 1
            WHEN 'Février' THEN 2
            WHEN 'Mars' THEN 3
            WHEN 'Avril' THEN 4
            WHEN 'Mai' THEN 5
            WHEN 'Juin' THEN 6
            WHEN 'Juillet' THEN 7
            WHEN 'Aout' THEN 8
            WHEN 'Septembre' THEN 9
            WHEN 'Octobre' THEN 10
            WHEN 'Novembre' THEN 11
            WHEN 'Décembre' THEN 12
            END";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION getHistorique
    | -------------------------
    | PARAM
    |   $id: (INT) - L'ID de l'événement historique à récupérer
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur l'événement historique demandé
    | -------------------------
    | DESCRIPTION
    |   Récupère les informations sur un événement historique dans la BDD
    |------------------------------------- */   
    public function getHistorique($id){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM historique WHERE evenementHistoriqueID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION editHistorique
    | -------------------------
    | PARAM
    |   $mois: (STR) - Le nom du mois où l'événement s'est produit
    |   $annee: (STR) - L'année où l'événement s'est produit
    |   $description: (STR) - Description de l'événement
    |   $evenementID: (INT) - L'ID de l'événement à modifier
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'édition s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Modifie un événement historique dans la BDD
    |------------------------------------- */   
    public function editHistorique($mois, $annee, $description, $evenementID){
        $PDO = $this->connexionBD();
        $query = "UPDATE historique SET  moisEvenementHistorique=:mois, anneeEvenementHistorique=:annee, descEvenementHistorique=:description WHERE evenementHistoriqueID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":mois", $mois, PDO::PARAM_INT);
        $PDOStatement->bindValue(":annee", $annee, PDO::PARAM_INT);
        $PDOStatement->bindValue(":description", $description, PDO::PARAM_INT);
        $PDOStatement->bindValue(":id", $evenementID, PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    
    /* -------------------------------------
    | FONCTION ajoutHistorique
    | -------------------------
    | PARAM
    |   $mois: (STR) - Le nom du mois où l'événement s'est produit
    |   $annee: (STR) - L'année où l'événement s'est produit
    |   $description: (STR) - Description de l'événement
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'ajout s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Ajoute un événement historique dans la BDD
    |------------------------------------- */   
    public function ajoutHistorique($mois, $annee, $description){
        $PDO = $this->connexionBD();
        $query = "INSERT INTO historique SET  moisEvenementHistorique=:mois, anneeEvenementHistorique=:annee,  descEvenementHistorique=:description, modificateurID=:modificateur";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":mois", $mois, PDO::PARAM_INT);
        $PDOStatement->bindValue(":annee", $annee, PDO::PARAM_INT);
        $PDOStatement->bindValue(":description", $description, PDO::PARAM_INT);
        $PDOStatement->bindValue(":modificateur", $_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    
    /* -------------------------------------
    | FONCTION deleteHistorique
    | -------------------------
    | PARAM
    |   $id: (INT) - Le ID de l'événement historique à supprimer
    | -------------------------
    | RETURN
    |   aucun
    | -------------------------
    | DESCRIPTION
    |   Supprime un événement historique de la BDD
    |------------------------------------- */   
     public function deleteHistorique($id) {
        $PDO = $this->connexionBD();
        $query = "DELETE FROM historique WHERE evenementHistoriqueID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $PDOStatement->execute();
    }
    
    /* -------------------------------------
    | FONCTION getCategories
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste des categories de ressources dans la BDD
    | -------------------------
    | DESCRIPTION
    |   Récupère la liste des catégories de ressources dans la BDD
    |------------------------------------- */   
    public function getCategories(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM categoriesressources";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
    }    
    
    /* -------------------------------------
    | FONCTION ajoutCategorie
    | -------------------------
    | PARAM
    |   $nom: (STR) - Le nom de la catégorie à ajouter
    | -------------------------
    | RETURN
    |   (BOOL) - TRUE si l'ajout s'est bien effectué, FALSE en cas d'erreur
    | -------------------------
    | DESCRIPTION
    |   Ajoute une catégorie de ressources à la BDD
    |------------------------------------- */   
    public function ajoutCategorie($nom){
        $PDO = $this->connexionBD();
        $query = "INSERT INTO categoriesressources SET nomCategorie=:nom";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":nom", $nom, PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    
    /* -------------------------------------
    | FONCTION deleteCategorie
    | -------------------------
    | PARAM
    |   $id: (INT) - Le ID de la categorie de ressources à supprimer
    | -------------------------
    | RETURN
    |   aucun
    | -------------------------
    | DESCRIPTION
    |   Supprime une categorie de ressources de la BDD
    |------------------------------------- */ 
     public function deleteCategorie($id) {
        $PDO = $this->connexionBD();
        $query = "DELETE FROM categoriesressources WHERE categorieID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $PDOStatement->execute();
    }
    
    
    /* -------------------------------------
    | FONCTION getRessources
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste des ressources et de leurs informations
    | -------------------------
    | DESCRIPTION
    |   Récupère la liste des ressources et leurs informations
    |------------------------------------- */   
    public function getRessources(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM ressources";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION getRessource
    | -------------------------
    | PARAM
    |   $id: (INT) - Le ID de la ressource à récupérer
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur la ressource
    | -------------------------
    | DESCRIPTION
    |   Récupère les informations sur une ressource dans la BDD
    |------------------------------------- */  
    public function getRessource($id){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM ressources WHERE ressourceID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION editRessource
    | -------------------------
    | PARAM
    |   $nom: (STR) - Le nom de la ressource
    |   $tel: (STR) - Le numéro de téléphone de la ressource (NULL POSSIBLE)
    |   $site: (STR) - L'adresse du site web de la ressource (NULL POSSIBLE)
    |   $categorie: (INT) - le ID de la catégorie à laquelle la ressource
    |       appartient
    |   $ressourceID: (INT) - Le ID de la ressource à modifier
    | -------------------------
    | RETURN
    |   (BOOL) - True si l'ajout s'est effectué, False dans le cas contraire
    | -------------------------
    | DESCRIPTION
    |   Modifie une ressource dans la BDD
    |------------------------------------- */   
    public function editRessource($nom, $tel, $site, $categorie, $ressourceID){
        $PDO = $this->connexionBD();
        $query = "UPDATE ressources SET nomRessource=:nom, categorieID=:categorie ";
        $query .=(isset($tel) && !empty($tel))?",telRessource=:tel ": ",telRessource=NULL ";
        $query .=(isset($site) && !empty($site))? ",siteRessource=:site ":",siteRessource=NULL ";
        $query .= "WHERE ressourceID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":nom", $nom, PDO::PARAM_INT);
         if(isset($tel) && !empty($tel))$PDOStatement->bindValue(":tel", $tel, PDO::PARAM_INT);
        if(isset($site) && !empty($site))$PDOStatement->bindValue(":site", $site, PDO::PARAM_INT);
        $PDOStatement->bindValue(":categorie", $categorie, PDO::PARAM_INT);
        $PDOStatement->bindValue(":id", $ressourceID, PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    
    /* -------------------------------------
    | FONCTION ajoutRessource
    | -------------------------
    | PARAM
    |   $nom: (STR) - Le nom de la ressource
    |   $tel: (STR) - Le numéro de téléphone de la ressource (NULL POSSIBLE)
    |   $site: (STR) - L'adresse du site web de la ressource (NULL POSSIBLE)
    |   $categorie: (INT) - le ID de la catégorie à laquelle la ressource
    |       appartient
    | -------------------------
    | RETURN
    |   (BOOL) - True si l'ajout s'est effectué, False dans le cas contraire
    | -------------------------
    | DESCRIPTION
    |   Ajoute une ressource dans la BDD
    |------------------------------------- */   
    public function ajoutRessource($nom, $tel, $site, $categorie){
        
        $PDO = $this->connexionBD();
        $query = "INSERT INTO ressources SET nomRessource=:nom, categorieID=:categorie, modificateurID=:modificateur ";
        if(isset($tel) && !empty($tel)) $query .=",telRessource=:tel ";
        if(isset($site) && !empty($site)) $query .=",siteRessource=:site ";
        
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":nom", $nom, PDO::PARAM_INT);
        if(isset($tel) && !empty($tel))$PDOStatement->bindValue(":tel", $tel, PDO::PARAM_INT);
        if(isset($site) && !empty($site))$PDOStatement->bindValue(":site", $site, PDO::PARAM_INT);
        $PDOStatement->bindValue(":categorie", $categorie, PDO::PARAM_INT);
        $PDOStatement->bindValue(":modificateur", $_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    
    /* -------------------------------------
    | FONCTION deleteRessource
    | -------------------------
    | PARAM
    |   $id: (INT) - Le ID de la ressource à supprimer
    | -------------------------
    | RETURN
    |   aucun
    | -------------------------
    | DESCRIPTION
    |   Supprime une ressource de la BDD
    |------------------------------------- */     
     public function deleteRessource($id) {
        $PDO = $this->connexionBD();
        $query = "DELETE FROM ressources WHERE ressourceID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $PDOStatement->execute();
    }
    
    
    /* -------------------------------------
    | FONCTION getDocuments
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste des documents disponibles et leurs informations
    | -------------------------
    | DESCRIPTION
    |   Récupère la liste des documents disponibles et leurs informations
    |------------------------------------- */   
    public function getDocuments(){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM documents";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION getDocument
    | -------------------------
    | PARAM
    |   $id: (INT) - Le document dont on veut les informations
    | -------------------------
    | RETURN
    |   (ARRAY) - Les informations sur le document
    |       Retourne bool(false) si une erreur se produit
    | -------------------------
    | DESCRIPTION
    |   Récupère les informations sur un document dans la BDD
    |------------------------------------- */   
    public function getDocument($id){
        $PDO = $this->connexionBD();
        $query = "SELECT * FROM documents WHERE documentID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
    
    /* -------------------------------------
    | FONCTION ajoutDocument
    | -------------------------
    | PARAM
    |   $nom: (STR) - Le nom du document tel qu'il doit être affiché
    |   $description: (STR) - Description du document telle qu'elle
    |       doit être affichée
    |   $url: (STR) - L'URL à utiliser pour atteindre le document quand
    |       on veut le télécharger.
    | -------------------------
    | RETURN
    |   (BOOL) - True si l'ajout s'est effectué, False dans le cas contraire
    | -------------------------
    | DESCRIPTION
    |   Ajoute les informations pour un document dans la BDD
    |------------------------------------- */   
    public function ajoutDocument($nom, $description, $url){
        
        $PDO = $this->connexionBD();
        $query = "INSERT INTO documents SET nomDocument=:nom, descriptionDocument=:description, urlDocument=:url, modificateurID=:modificateur ";
        
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":nom", $nom, PDO::PARAM_INT);
        $PDOStatement->bindValue(":description", $description, PDO::PARAM_INT);
        $PDOStatement->bindValue(":url", $url, PDO::PARAM_INT);
        $PDOStatement->bindValue(":modificateur", $_SESSION['userID'], PDO::PARAM_INT);
        return $PDOStatement->execute();
    }
    
    /* -------------------------------------
    | FONCTION deleteDocument
    | -------------------------
    | PARAM
    |   $id: (INT) - Le ID du document à supprimer
    | -------------------------
    | RETURN
    |   aucun
    | -------------------------
    | DESCRIPTION
    |   Supprime un document de la BDD
    |------------------------------------- */   
     public function deleteDocument($id) {
        $PDO = $this->connexionBD();
        $query = "DELETE FROM documents WHERE documentID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $PDOStatement->execute();
    }
    
}

?>