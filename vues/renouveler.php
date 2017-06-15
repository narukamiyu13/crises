<?php
/* -------------------------------------
| fichier renouveler.php
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
|   VUE - Affichage de la page "Renouvellement d'adhésion"
|------------------------------------- */
    $msg = "&nbsp;";
    $parametres = $this->modele->getParametres();
if(isset($_GET['err'])) $msg = "Un champ n'est pas rempli adéquatement. Veuillez vérifier les informations.";

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devenir Membre - Les services de Crises de Lanaudière</title>
    <link rel="stylesheet" type="text/css" href="assets/fonts/fonts.css" />
    <link rel="stylesheet" type="text/css" href="assets/style/reset.css" />
    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    <link rel="stylesheet" type="text/css" media="screen and (max-width:600px)" href="assets/style/styleMobile.css" />
    <script src="assets/script/jquery-3.2.1.js"></script>
    <script>
          $(document).ready(function(){
            $("#boutonMobile").click(function(){
                if($("header").hasClass("open") == false){
                    $("header").addClass("open");
                } else {
                     $("header").removeClass("open");
                }
            })
                    
              $("input[name^='telResidentiel'],input[name^='cell']").keyup(function(){
                console.log(this);
                nextPhone(this, this.nextElementSibling);
            })
        
              
        })
        
      
    function nextPhone(thisField, nextField) {
        if (thisField.value.length >= thisField.maxLength) {
            nextField.focus();
        }
    }
        
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
                        <p class="current"><a href="devenirMembre.html">S'engager</a></p>
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
                        <p><a href="bottin.html">Bottin de ressources</a></p>
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

        <section class="formulaireAdhesion">
            <div id="container">
                <h2>Renouveler son adhésion</h2>
                <div class="content">
                    <p>Merci de votre fidélité, chacun de nos membres est important pour nous. En renouvelant votre adhésion, votre cotisation de <?=$parametres['coutCotisationRenouvellement'] ?>$ prolonge pour une autre année vos privilèges de membre.</p><br/>
                    <p>Si vous n'êtes pas encore membre et que vous souhaitez adhérer, remplissez <a href="devenirMembre.html" style="text-decoration:underline">ce formulaire-ci</a>.</p>
                </div>
                
                <form method="post" action="renouvelerSuite.html">
                    <input type="text" name="noMembre"  placeholder="No. de membre (optionnel)" value="<?=isset($_GET['noMembre'])?$_GET['noMembre'] : ""?>" />
                    <div style='margin-top:15px;margin-bottom:30px;'>
                        <p style="color:red;"><?= $msg?></p>
                        <p class="legendeFormAdhesion" style='margin-bottom:5px;'>Je souhaite être...</p>
                        <input type="radio" name="typeMembre" id="radioActif" value="actif" <?= isset($_GET['typeMembre']) && $_GET['typeMembre'] == "actif"? "checked": "" ?> required/><label for="radioActif">Membre actif <span>?<span class='infobulle'>Toute personne qui habite ou oeuvre dans la région de Lanaudière, participant ou ayant participé aux activités de la corporation ou s'est prévalue de ses services et qui souscrit aux exigences de la corporation.</span></span></label>
                        <input type="radio" name="typeMembre" id="radioAffinitaire" value="affinitaire" <?= isset($_GET['typeMembre']) && $_GET['typeMembre'] == "affinitaire"? "checked": "" ?>/><label for="radioAffinitaire">Membre Affinitaire <span>?<span class='infobulle'>Toute personne qui habite ou oeuvre dans la région de Lanaudière, intéressée à promouvoir les intérêts de la corporation et qui souscrit aux exigences de la corporation.</span></span></label>
                    </div>
                    
                    <input type="text" name="prenom"  placeholder="prénom"  value="<?=isset($_GET['prenom'])?$_GET['prenom'] : ""?>" required/>
                    <input type="text" name="nom"  placeholder="nom"  value="<?=isset($_GET['nom'])?$_GET['nom'] : ""?>" required/><br> 
                    <span class="legendeFormAdhesion">Téléphone domicile</span>
                    <input type="text" name="telResidentiel1" placeholder="012"  maxlength="3" value="<?=isset($_GET['tel1'])?$_GET['tel1'] : ""?>" required>
                    <input type="text" name="telResidentiel2" placeholder="345"  maxlength="3" value="<?=isset($_GET['tel2'])?$_GET['tel2'] : ""?>" required>
                    <input type="text" name="telResidentiel3" placeholder="6789"  maxlength="4" value="<?=isset($_GET['tel3'])?$_GET['tel3'] : ""?>" required><br>
                    <span class="legendeFormAdhesion">Téléphone mobile (optionnel)</span>
                    <input type="text" name="cell1" placeholder="012"  maxlength="3" value="<?=isset($_GET['cell1'])?$_GET['cell1'] : ""?>">
                    <input type="text" name="cell2" placeholder="345"  maxlength="3" value="<?=isset($_GET['cell2'])?$_GET['cell2'] : ""?>">
                    <input type="text" name="cell3" placeholder="6789" maxlength="4" value="<?=isset($_GET['cell3'])?$_GET['cell3'] : ""?>"><br>
                    
                    <input type="email" name="courriel" placeholder="adresse courriel" value="<?=isset($_GET['courriel'])?$_GET['courriel'] : ""?>" required><br>
                    
                    
                    
                    <input type="text" name="adresse" placeholder="adresse (123 colline-verte)" value="<?=isset($_GET['adresse'])?$_GET['adresse'] : ""?>" required>
                    <input type="text" name="ville" placeholder="ville" value="<?=isset($_GET['ville'])?$_GET['ville'] : ""?>" required>
                    <input type="text" name="codePostal" placeholder="code postal" value="<?=isset($_GET['codePostal'])?$_GET['codePostal'] : ""?>" required><br>
                    
                    <div style='margin-top:15px;margin-bottom:30px;'>
                        <p class="legendeFormAdhesion" style='margin-bottom:5px;'>Je préfère qu'on corresponde avec moi...</p>
                        <input type="radio" name="typeCommunication" id="radioCourriel" value="courriel" <?= isset($_GET['typeCommunication']) && $_GET['typeCommunication'] == "courriel"? "checked" : "" ?> required/><label for="radioCourriel">Par Courriel</label>
                        <input type="radio" name="typeCommunication" id="radioPoste" value="poste" <?=isset($_GET['typeCommunication']) && $_GET['typeCommunication'] == "poste"? "checked" : "" ?>/><label for="radioPoste">Par la poste</label><br>
                    </div>
                    
                    
                    <input type='submit' name="continuer" value="Continuer">
                </form>
                
            </div>
        </section>
        </div>
    <footer>
    <p><a href="documents.html">Document à télécharger</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="contact.html">Contacter l'administration</a></p>
        <p>©Les Services de Crise de Lanaudière, 2017 <br><?=$parametres['creditFooter'] != 0?"<span>Conception par Cédrick Collin.</span>":"" ?></p>
    </footer>

</body>
</html>