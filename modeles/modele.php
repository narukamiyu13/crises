<?php
/* -------------------------------------
| fichier modele.php
| -------------------------
| CONTRIBUTEURS
|   Auteur: Cédrick Collin
|   Modifications: Cédrick Collin
| -------------------------
| DATES
|   Création: 2 mai 2017
|   Dernière Modification: 30 mai 2017
| -------------------------
| DESCRIPTION
|   MODELE - Le modèle de fonctions coté client, sous forme
|   de classe.
|------------------------------------- */
class Modele{
    
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
    public function connexionBD(){
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8');
        $PDO = new PDO("mysql:host=localhost;dbname=", "", "", $options);
        return $PDO;
    }
    
    /* -------------------------------------
    | FONCTION getTexte
    | -------------------------
    | PARAM
    |   $colonne: (STRING) - Le nom de la colonne dont on veut récupérer
    |       la valeur dans la BDD
    |   $table: (STRING) - Le nom de la table où aller chercher la colonne
    |       et son information.
    | -------------------------
    | RETURN
    |   (STRING) - Le texte récupéré dans la BDD
    |   Retourne bool(false) en cas d'erreur.
    | -------------------------
    | DESCRIPTION
    |   Récupère un texte à afficher dans la BDD selon une colonne et une 
    |   table donnée.
    |------------------------------------- */   
     public function getTexte($colonne, $table){
        $PDO = $this->connexionBD();
        $query = "SELECT $colonne FROM $table";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_NUM)[0];
    }
    
    /* -------------------------------------
    | FONCTION getHistorique
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - Les événements historiques, triés par ordre de croissant d'année
    |       et de mois. (ex: janvier 2009 avant mars 2009, et janvier 2010 après janvier 2009)
    |   Retourne bool(false) en cas d'erreur.
    | -------------------------
    | DESCRIPTION
    |   Récupère les événements d'historique en ordre afin de les afficher.
    |------------------------------------- */   
    public function getHistorique(){
        $PDO = $this->connexionBD();
        $query = "SELECT moisEvenementHistorique, anneeEvenementHistorique, descEvenementHistorique FROM historique 
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
    | FONCTION getEvenements
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - Les événements organisés à afficher
    |   Retourne bool(false) en cas d'erreur.
    | -------------------------
    | DESCRIPTION
    |   Récupère la liste des événements organisés afin de les afficher
    |   dans la page.
    |------------------------------------- */   
    public function getEvenements(){
        $PDO = $this->connexionBD();
        $query = "SELECT `nomEvenement`,`descriptionEvenement`,`dateEvenement` FROM evenements ORDER BY dateEvenement DESC";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /* -------------------------------------
    | FONCTION getTemoignages
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste des témoignages entrés dans la BDD
    |   Retourne bool(false) en cas d'erreur.
    | -------------------------
    | DESCRIPTION
    |   Récupère la liste des témoignages dans la BDD afin de les afficher.
    |------------------------------------- */   
    public function getTemoignages(){
        $PDO = $this->connexionBD();
        $query = "SELECT texteTemoignage, temoigneur FROM temoignages";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_NUM);
    }
    
    
    /* -------------------------------------
    | FONCTION getCategoriesRessources
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste des catégories de ressources dans la BDD
    |   Retourne bool(false) en cas d'erreur.
    | -------------------------
    | DESCRIPTION
    |   Récupère la liste des catégories de ressources afin d'afficher
    |   les titres dans la liste de ressources.
    |------------------------------------- */   
    public function getCategoriesRessources(){
        $PDO = $this->connexionBD();
        $query = "SELECT * from categoriesressources";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /* -------------------------------------
    | FONCTION getRessources
    | -------------------------
    | PARAM
    |   $idCategorie: (INT) - Le ID de la catégories de ressources qu'on
    |   veut. 
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste des ressources dans la catégorie désirée
    |   Retourne bool(false) en cas d'erreur.
    | -------------------------
    | DESCRIPTION
    |   Récupère la liste des ressources sous une certaine catégorie afin de
    |   les afficher.
    |------------------------------------- */   
    public function getRessources($idCategorie){
        $PDO = $this->connexionBD();
        $query = "SELECT nomRessource, telRessource, siteRessource, categorieID FROM ressources WHERE categorieID=:id";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":id", $idCategorie, PDO::PARAM_INT);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_BOTH);
    }
    
    /* -------------------------------------
    | FONCTION filtrerRessources
    | -------------------------
    | PARAM
    |   $filtre: (STRING) - Le filtre à employer pour filtrer les ressources
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste de résultats de ressources filtrées
    |   Retourne bool(false) en cas d'erreur.
    | -------------------------
    | DESCRIPTION
    |   Récupère la liste des ressources selon un filtre, afin de permettre de
    |   rechercher des ressources
    |------------------------------------- */   
    public function filtrerRessources($filtre){
        $PDO = $this->connexionBD();
        $filtre = "%$filtre%";
        $query = "SELECT nomRessource, telRessource, siteRessource, categorieID FROM ressources WHERE nomRessource LIKE :filtre";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->bindValue(":filtre", $filtre, PDO::PARAM_STR);
        $PDOStatement->execute();
        $resultat = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }
    

    /* -------------------------------------
    | FONCTION getDocuments
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - La liste des documents téléchargeables
    |   Retourne bool(false) en cas d'erreur.
    | -------------------------
    | DESCRIPTION
    |   Récupère la liste des documents téléchargeables dans la BDD
    |------------------------------------- */   
    public function getDocuments(){
        $PDO = $this->connexionBD();
        $query = "SELECT nomDocument, urlDocument, descriptionDocument FROM documents";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_BOTH);
    }
    
     
    
    /* -------------------------------------
    | FONCTION getParametres
    | -------------------------
    | PARAM
    |   aucun
    | -------------------------
    | RETURN
    |   (ARRAY) - Les paramètres du site
    |   Retourne bool(false) en cas d'erreur.
    | -------------------------
    | DESCRIPTION
    |   Récupère les paramètres du site
    |------------------------------------- */   
    public function getParametres(){
        $PDO = $this->connexionBD();
        $query = "SELECT *
                  FROM parametressite";
        $PDOStatement = $PDO->prepare($query);
        $PDOStatement->execute();
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    }
    
   
    
}

?>