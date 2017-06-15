<?php
/* -------------------------------------
| fichier controleurAjax.php
| -------------------------
| CONTRIBUTEURS
|   Auteur: Cédrick Collin
|   Modifications: Cédrick Collin
| -------------------------
| DATES
|   Création: 3 mai 2017
|   Dernière Modification: 4 mai 2017
| -------------------------
| DESCRIPTION
|   CONTROLEUR - Gère l'affichage par Ajax des ressources du bottin.
|------------------------------------- */
require_once("../modeles/modele.php");

$modele = new Modele();

if(isset($_POST['filtre'])) {
      
    
        if($_POST['filtre'] == "") {
            foreach($modele->getCategoriesRessources() as $categorie) {
                $cpt = 0;
                echo "<h3>".$categorie['nomCategorie']."</h3>";
                foreach($modele->getRessources($categorie['categorieID']) as $ressource){
                    $cpt++;
                    echo "<p class='ressource'>".$ressource['nomRessource']."<br><span>";
                echo ($ressource['telRessource'] == NULL)? "Sur référence" : $ressource['telRessource'];
                echo ($ressource['siteRessource'] == NULL)? "" : " - <a href='".$ressource['siteRessource']."'>Site web</a></span></p>";
                }

                if($cpt == 0) {
                    echo "<p class='ressource'> Pas de ressources dans cette categorie en ce moment";
                }
            }
        } else {
              $cpt = 0;
            echo "<h3>Résultats</h3>";
            foreach($modele->filtrerRessources($_POST['filtre']) as $resultat) {
                $cpt++;
                echo "<p class='ressource'>".$resultat['nomRessource']."<br><span>";
                echo ($resultat['telRessource'] == NULL)? "Sur référence" : $resultat['telRessource'];
                echo ($resultat['siteRessource'] == NULL)? "" : " - <a href='".$resultat['siteRessource']."'>Site web</a></span></p>";
            }

            if($cpt == 0) {
                echo "<p class='ressource'> La recherche n'a retourné aucun résultat";
            }
        }
    }
    
    ?>