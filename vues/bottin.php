<!doctype html>
<?php
/* -------------------------------------
| fichier bottin.php
| -------------------------
| CONTRIBUTEURS
|   Auteur: Cédrick Collin
|   Modifications: Cédrick Collin
| -------------------------
| DATES
|   Création: 2 mai 2017
|   Dernière Modification: 25 mai 2017
| -------------------------
| DESCRIPTION
|   VUE - Affichage du bottin de ressources
|------------------------------------- */
$parametres = $this->modele->getParametres();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bottin de Ressources - Les services de Crises de Lanaudière</title>
    <link rel="stylesheet" type="text/css" href="assets/fonts/fonts.css" />
    <link rel="stylesheet" type="text/css" href="assets/style/reset.css" />
    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    <link rel="stylesheet" type="text/css" media="screen and (max-width:600px)" href="assets/style/styleMobile.css" />
    <script src="assets/script/jquery-3.2.1.js"></script>
    <script>
        
        
        $(document).ready(function(){
           $("#searchRessource").keyup(function(){
               //console.log($("#searchRessource").val());
               var texte = $("#searchRessource").val();
               $.ajax({
                   url:  "controleurs/controleurAjax.php",
                   type: "POST",
                   data: {filtre: texte},
                   success: function(data){
                       $("#bottin").html(data);
                   }
               })
           })
            
              $("#boutonMobile").click(function(){
                if($("header").hasClass("open") == false){
                    $("header").addClass("open");
                } else {
                     $("header").removeClass("open");
                }
            })
            
        });
        
        
        
        
        
    </script>
<script>   (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),   m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)   })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');    ga('create', 'UA-99737178-1', 'auto');   ga('send', 'pageview');  </script></head>
<body>
    <div class="page-wrap">
        <header>
            <h1 style="display:none;">Les services de crises de lanaudière</h1>
            <a href="index.php"><img src="assets/images/logo.png" alt="Logo des Services de crises de Lanaudière" /></a>
            <p><?=$parametres['telephoneCrise'] ?></p>
            <nav>
                <ul>
                    <li id="boutonMobile">
                        <p>&#9776;</p>
                    </li>
                    <li>
                        <p><a href="lorganisme.html">L'organisme</a></p>
                        <ul>
                            <li>
                                <p><a href="historique.html">Historique</a></p>
                                <p><a href="philosophie.html">Philosophie</a></p>
                            </li>
                        </ul>
                    </li>
                     <li>
                        <p><a href="services.html">Services</a></p>
                        <ul>
                            <li>
                                <p><a href="services.html#intervention">Intervention Téléphonique</a></p>
                                <p><a href="services.html#sejours">Séjours de crise</a></p>                                 <p><a href="services.html#relance">Relance Téléphonique</a></p>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <p><a href="admissibilite.html">Admissibilité</a></p>
                        <ul>
                            <li>
                                <p><a href="definition.html">Définition d'une crise</a></p>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <p><a href="devenirMembre.html">S'engager</a></p>
                        <ul>
                            <li>
                                <p><a href="devenirMembre.html">Devenir Membre</a></p>
                                <p><a href="don.html">Faire un Don</a></p>
                                <p><a href="emplois.html">Emplois</a></p>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <p><a href="evenements.html">Événements</a></p>
                    </li>
                    <li>
                        <p class="current"><a href="bottin.html">Bottin de ressources</a></p>
                    </li>
                    <li>
                        <p><a href="temoignages.html">Témoignages</a></p>
                    </li>
                    <li class="mobileOnly">
                        <p><a href="documents.html">Documents à télécharger</a></p>
                    </li>
                    <li class="mobileOnly">
                        <p><a href="contact.html">Contacter l'administration</a></p>
                    </li>
                    <li class="mobileOnly">
                        <p>©Les Services de Crise de Lanaudière, 2017 <br><span>Conception par Cédrick Collin.</span></p>
                    </li>
                </ul>
            </nav>
        </header>

        <section>
            <div id="container">
                <h2>Bottin de ressources</h2>
                <div class="content">
                    <p>Vous trouverez sur cette page une liste de ressources dans Lanaudière pour les personnes en difficulté.</p>
                </div>
                <input type="text" id="searchRessource" placeholder="Rechercher une ressource..." />
                <div id="bottin">
                    <?php

                        foreach($this->modele->getCategoriesRessources() as $categorie) {
                            $cpt = 0;
                            echo "<h3>".$categorie['nomCategorie']."</h3>";
                            foreach($this->modele->getRessources($categorie['categorieID']) as $ressource){
                                $cpt++;
                                echo "<p class='ressource'>".$ressource['nomRessource']."<br><span>";
                                echo ($ressource['telRessource'] == NULL)? "Téléphone Sur référence" : $ressource['telRessource'];
                                echo ($ressource['siteRessource'] == NULL)? "" : " - <a href='".$ressource['siteRessource']."' target='_blank'>Site web</a></span></p>";
                            }

                            if($cpt == 0) {
                                echo "<p class='ressource'> Pas de ressources dans cette categorie en ce moment";
                            }
                        }

                    ?>
                </div>
            </div>
        </section>
        </div>
    <footer>
    <p><a href="documents.html">Document à télécharger</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="contact.html">Contacter l'administration</a></p>
        <p>©Les Services de Crise de Lanaudière, 2017 <br><?=$parametres['creditFooter'] != 0?"<span>Conception par Cédrick Collin.</span>":"" ?></p>
    </footer>

</body>
</html>