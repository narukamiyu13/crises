<!doctype html>
<?php
/* -------------------------------------
| fichier devenirMembreSuite.php
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
|   VUE - Affichage de la page de confirmation et d'impression de "Devenir Membre"
|------------------------------------- */
$parametres = $this->modele->getParametres();
?>

<?php
$err = [];

if(isset($_POST['typeMembre'])) {
   $typeMembre = $_POST['typeMembre'] == "actif"? "actif": "affinitaire";
}

if(isset($_POST['prenom']) && !empty($_POST['prenom']) && !preg_match_all('/[0-9¤\{\}\[\]¬!@#\$%\?&\*\(\)\|\/\\<>°`~\.,"]/',$_POST['prenom'])){
    $prenom = ucfirst(strtolower($_POST['prenom']));
} else {
    $err[] = "prenom";
}

if(isset($_POST['nom']) && !empty($_POST['nom']) && !preg_match_all('/[0-9¤\{\}\[\]¬!@#\$%\?&\*\(\)\|\/\\<>°`~\.,"]/',$_POST['nom'])){
    $nom = ucfirst(strtolower($_POST['nom']));
} else {
    $err[] = "nom";
}

if(isset($_POST['telResidentiel1']) && !empty($_POST['telResidentiel1']) && preg_match('/[0-9]{3}/',$_POST['telResidentiel1']) &&
   isset($_POST['telResidentiel2']) && !empty($_POST['telResidentiel2']) && preg_match('/[0-9]{3}/',$_POST['telResidentiel2']) &&
   isset($_POST['telResidentiel3']) && !empty($_POST['telResidentiel3']) && preg_match('/[0-9]{4}/',$_POST['telResidentiel3']) ){
    $tel1=$_POST['telResidentiel1'];
    $tel2=$_POST['telResidentiel2'];
    $tel3=$_POST['telResidentiel3'];
    $telResidentiel = "(".$_POST['telResidentiel1'].") ".$_POST['telResidentiel2']."-".$_POST['telResidentiel3'];
} else {
    $err[] = "tel";
}

if(isset($_POST['cell1']) && !empty($_POST['cell1']) && preg_match('/[0-9]{3}/',$_POST['cell1']) &&
   isset($_POST['cell2']) && !empty($_POST['cell2']) && preg_match('/[0-9]{3}/',$_POST['cell2']) &&
   isset($_POST['cell3']) && !empty($_POST['cell3']) && preg_match('/[0-9]{4}/',$_POST['cell3']) ){
    $cell1=$_POST['cell1'];
    $cell2=$_POST['cell2'];
    $cell3=$_POST['cell3'];
    $cell = "(".$_POST['cell1'].") ".$_POST['cell2']."-".$_POST['cell3'];
} else {
    $cell1="";
    $cell2="";
    $cell3="";
    $cell = NULL;
}



if(isset($_POST['courriel']) && !empty($_POST['courriel']) && preg_match('/[a-zA-Z0-9]+\@[a-zA-Z0-9]+\.[a-z]{2,}/',$_POST['courriel'])){
    $courriel = strtolower($_POST['courriel']);
} else {
    $err[] = "courriel";
}
// D, F, I, O, Q et U ne sont pas utilisées : elles pourraient être confondues avec d'autres lettres, surtout en écriture cursive. Les lettres W et Z sont utilisées, mais jamais en première position
if(isset($_POST['codePostal']) && !empty($_POST['codePostal'])){
    $codePostal = preg_replace("/ /", "", $_POST['codePostal']);
    if(preg_match('/[a-cA-CeEghGHj-nJ-NpPr-tR-TvVxyXY][0-9][a-cA-CeEghGHj-nJ-NpPr-tR-Tv-zV-Z][0-9][a-cA-CeEghGHj-nJ-NpPr-tR-Tv-zV-Z][0-9]/',$codePostal)){
       $codePostal = strtoupper(substr_replace($codePostal, " ", 3,0)); 
    } else {
        $err[] = "codePostal";
    }
    
} else {
    $err[] = "codePostal";
}

if(isset($_POST['adresse']) && !empty($_POST['adresse']) && preg_match('/[0-9]+ [a-zA-ZèàéêëËÊÈÀÉùÙ0-9\- ]+/',$_POST['adresse'])){
    $adresse = strtolower($_POST['adresse']);
} else {
    $err[] = "adresse";
}

if(isset($_POST['ville']) && !empty($_POST['ville']) && !preg_match('/[0-9¤\{\}\[\]¬!@#\$%\?&\*\(\)\|\/\\<>°`~\.,"]/',$_POST['ville'])){
    $ville = ucfirst(strtolower(htmlentities($_POST['ville'])));
} else {
    $err[] = "ville";
}

if(isset($_POST['typeCommunication'])) {
    $typeCommunication = $_POST['typeCommunication'] == "courriel"? "courriel" : "poste" ;
}



if(count($err) > 0) {
    header("location:devenirMembre.html?&err&typeMembre=$typeMembre&prenom=$prenom&nom=$nom&tel1=$tel1&tel2=$tel2&tel3=$tel3&cell1=$cell1&cell2=$cell2&cell3=$cell3&courriel=$courriel&codePostal=$codePostal&adresse=$adresse&ville=$ville&typeCommunication=$typeCommunication");
}

 setlocale(LC_ALL, '');
?>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devenir Membre - Les services de Crises de Lanaudière</title>
    <link rel="stylesheet" type="text/css" href="assets/fonts/fonts.css" />
    <link rel="stylesheet" type="text/css" href="assets/style/reset.css" />
    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    <link rel="stylesheet" type="text/css" media="screen and (max-width:600px)" href="assets/style/styleMobile.css" />
    <link rel="stylesheet" type="text/css" media="print" href="assets/style/printAdhesion.css" />
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
              
        }) 
            
                    
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
                <h2>Devenir Membre</h2>
                <div class="content">
                    <p>Prière de réviser les informations ci-dessous afin de s'assurer qu'elles sont exactes. En cas d'erreur, vous pouvez <a href="<?= "devenirMembre.html?typeMembre=$typeMembre&prenom=$prenom&nom=$nom&tel1=$tel1&tel2=$tel2&tel3=$tel3&cell1=$cell1&cell2=$cell2&cell3=$cell3&courriel=$courriel&codePostal=$codePostal&adresse=$adresse&ville=$ville&typeCommunication=$typeCommunication" ?>" style="text-decoration:underline">retourner au formulaire</a> afin de les corriger.</p>
                </div>
                <div id="infos">
                    
                        <p>Nom complet :<span><?=$prenom?> <?=$nom?></span></p>
                        <p>Téléphone domicile :<span><?=$telResidentiel?></span></p>
                        <p>Téléphone mobile :<span><?=isset($cell)? $cell : "Non défini"?></span></p>
                        <p>Courriel :<span><?=$courriel?></span></p>
                        <p>Adresse Postale :<span><?=$adresse?>, <?=$ville?>, <?=$codePostal?></span></p>
                        <p>Communication préférée par :<span><?=$_POST['typeCommunication'] == "poste"? "Poste" : "Courriel" ?></span></p>
                        <p>Vous souhaitez être :<span><?=$_POST['typeMembre'] == "actif"? "Membre actif" : "Membre affinitaire" ?></span></p>
                    
                    
                </div>
                
                
                <div id="print">
                    <input type="submit" value="Imprimer mon formulaire" onclick="window.print();" />
                </div>
                <div style="clear:both;margin-bottom:50px;"></div>
                
            </div>
        </section>
        <div id="printInfos">
            
            <?php
                $patterns = array('/January/i', '/February/i','/March/i','/April/i','/May/i','/June/i','/July/i','/August/i','/September/i','/October/i','/November/i','/December/i');
                $remplacements = array('Janvier', 'Février','Mars', 'Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
                
                $date = utf8_encode(strftime("%e %B %Y"));
                $date = preg_replace($patterns,$remplacements, $date);
            ?>
        <h2>Formulaire d'adhésion</h2>
            <p>Les services de crise de Lanaudière est un organisme communautaire à mandat régional. Il offre une alternative à l'hospitalisation pour toute personne adulte qui vit une situation de crise par le biais de séjours dans l'une de ses deux Maisons: Rawdon et Repentigny. Une équipe d'intervenants supporte la personne dans sa reprise de contrôle de la situation.</p>
            <br>
            <p>Si vous êtes sensibles à la mission de l'organisme, vous pouvez devenir membre. Ainsi, vons contribuerez à son soutien.</p>
            
            <input type="radio" name="typeMembre" id="radioActif" value="actif" <?= $_POST['typeMembre'] == "actif"? "checked": "" ?> required/><label for="radioActif">Membre actif </label>
            
            <input type="radio" name="typeMembre" id="radioAffinitaire" value="affinitaire" <?= $_POST['typeMembre'] == "affinitaire"? "checked": "" ?>/><label for="radioAffinitaire">Membre Affinitaire</label>
            
            <p id="date"> <span>Date :</span> <?= $date ?></p>
            <p id="prenom"> <span>Prénom :</span> <?= $prenom ?></p>
            <p id="nom"> <span>Nom : </span><?= $nom ?></p>
            <p id="adresse"> <span>Adresse :</span> <?= $adresse ?></p>
            <p id="ville"> <span>Municipalité :</span> <?= $ville ?></p>
            <p id="codePostal"> <span>Code Postal :</span> <?= $codePostal ?></p>
            <p id="telResidentiel"> <span>Téléphone résidentiel :</span> <?= $telResidentiel ?></p>
            <p id="cell"> <span>Téléphone cellulaire :</span> <?= $cell?></p>
            <p id="courriel"> <span>Courriel :</span> <?= $courriel ?></p>
            
            <p class="legendeFormAdhesion" style='margin-bottom:5px;'>Je préfère qu'on corresponde avec moi...</p>
                        <input type="radio" name="typeCommunication" id="radioCourriel" value="courriel" <?=$_POST['typeCommunication'] == "courriel"? "checked" : "" ?> required/><label for="radioCourriel">Par Courriel</label>
                        <input type="radio" name="typeCommunication" id="radioPoste" value="poste" <?=$_POST['typeCommunication'] == "poste"? "checked" : "" ?>/><label for="radioPoste">Par la poste</label>
            
           
            <div class="print-bottom">
                 <hr/>
                <p>Veuillez retourner par la poste le formulaire complété ainsi que le montant de la cotisation à:</p>
                <p>Les Services de crise de Lanaudière<br>
                <?=$parametres['adresse'] ?><br>
                <?=$parametres['ville'] ?>, Québec<br>
                <?=$parametres['codePostal'] ?></p>
            </div>
        </div>
    </div>
    <footer>
    <p><a href="documents.html">Document à télécharger</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="contact.html">Contacter l'administration</a></p>
        <p>©Les Services de Crise de Lanaudière, 2017 <br><?=$parametres['creditFooter'] != 0?"<span>Conception par Cédrick Collin.</span>":"" ?></p>
    </footer>

</body>
</html>