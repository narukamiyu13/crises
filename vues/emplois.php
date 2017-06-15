<!doctype html>
<?php
/* -------------------------------------
| fichier emplois.php
| -------------------------
| CONTRIBUTEURS
|   Auteur: Cédrick Collin
|   Modifications: Cédrick Collin
| -------------------------
| DATES
|   Création: 2 mai 2017
|   Dernière Modification: 31 mai 2017
| -------------------------
| DESCRIPTION
|   VUE - Affichage de la page "Emplois"
|------------------------------------- */
$msg = "&nbsp;";
$parametres = $this->modele->getParametres();

require_once("assets/script/extensions/PHPMailer/PHPMailerAutoload.php");

if(isset($_POST['postuler'])){
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $courriel = $_POST['courriel'];
    $CV = $_FILES['cv'];
    $telephone = $_POST['telephone'];
    $direction = $parametres['courrielDirection'];
    $mailAdmin = new PHPMailer;
    $mailAdmin->CharSet = 'UTF-8';
    $mailAdmin->setFrom("nepasrepondre@crise.lanaudiere.net");
    $mailAdmin->addAddress($direction);
    $mailAdmin->Subject = "Candidature Reçue: $prenom $nom";
    $mailAdmin->addAttachment($CV['tmp_name'],$CV['name'], 'base64', $CV['type']);
    $mailAdmin->Body = "
    Bonjour! \n
    La présente est pour vous informer que $prenom $nom vient d'envoyer sa candidature pour travailler avec les Services de crises de Lanaudière. Vous trouverez son CV en pièce jointe, ainsi que les coordonnées pour le/la contacter ci-dessous. \r\n
    \r\n
    Courriel : $courriel \r\n
    Téléphone: $telephone \r\n
    \r\n
    \r\n

    Ceci est un message automatisé. Merci de ne pas y répondre.";
    
    if($mailAdmin->send()) {
      $msg = 'Votre candidature a été envoyée!';
   }
    
    
    
    

}


$err = "";
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emplois - Les services de Crises de Lanaudière</title>
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

        <section>
            <div id="container">
                <h2>Travailler avec les Services de Crise de Lanaudière</h2>
                <div class="content">
                        
                        <?= $this->modele->getTexte("texteEmplois", "contenuEmplois") ?>
                        
                        <p><?= $parametres['courrielDirection']; ?><?php
                            
                            ?></p> 
<!--
                    <form method="post" id="ouverture" action="emplois.html" enctype="multipart/form-data" >
                        <input type="text" name="prenom" placeholder="Prénom" required/>
                        <input type="text" name="nom" placeholder="Nom" required/>
                        <input type="email" name="courriel" placeholder="Courriel"  required/>
                        <input type="text" name="telephone" placeholder="Téléphone"  required/>
                        <input type="file" id="cv" name="cv" placeholder="Curriculum Vitae" required/><label for="cv">Joignez votre CV</label>
                        <input type="submit" name="postuler" value="Postuler" />
                    </form>
-->
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