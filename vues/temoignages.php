<!doctype html>
<?php
/* -------------------------------------
| fichier temoignages.php
| -------------------------
| CONTRIBUTEURS
|   Auteur: Cédrick Collin
|   Modifications: Cédrick Collin
| -------------------------
| DATES
|   Création: 17 mai 2017
|   Dernière Modification: 25 mai 2017
| -------------------------
| DESCRIPTION
|   VUE - Affichage de la page "Témoignages"
|------------------------------------- */
$parametres = $this->modele->getParametres();
?>

<?php 
$msg = "&nbsp;";
$couleur = "";
$err = [];
if(isset($_POST['postuler'])){
    var_dump($_FILES);
    if(isset($_POST['prenom']) && !empty($_POST['prenom']) && !preg_match_all('/[0-9¤\{\}\[\]¬!@#\$%\?&\*\(\)\|\/\\<>°`~\.,"]/', $_POST['prenom'])) {
        $prenom = $_POST['prenom'];
    } else {
        $err[] = "prenom";
    }
    
    if(isset($_POST['nom']) && !empty($_POST['nom']) && !preg_match_all('/[0-9¤\{\}\[\]¬!@#\$%\?&\*\(\)\|\/\\<>°`~\.,"]/', $_POST['nom'])) {
        $nom = $_POST['nom'];
    } else {
        $err[] = "nom";
    }
    
    if(isset($_POST['courriel']) && !empty($_POST['courriel']) && preg_match('/[a-zA-Z0-9]+\@[a-zA-Z0-9]+\.[a-z]{2,}/',$_POST['courriel'])){
    $courriel = strtolower($_POST['courriel']);
    } else {
        $err[] = "courriel";
    }
    
    $telephone = $_POST['telephone'];
    
    if(count($err) == 0) {
        $couleur = "#008800";
        $msg = "Merci, nous avons bien recu votre candidature.";
    } else {
        $msg = "Des erreurs se sont glissées dans le formulaire, veuillez vérifier les champs vides";
        $couleur = "#880000";
    }
}


?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Témoignages - Les services de Crises de Lanaudière</title>
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
            
            
            var labelval = $('input[type="file"] + label').html();
            console.log(labelval);
            
            $('input[type="file"]').change(function(){
                var fileName = $(this).val().split('\\').pop();
                console.log(fileName);
            
                if(fileName) {
                    $('input[type="file"] + label').html(fileName);
                } else {
                    $('input[type="file"] + label').html(labelval);
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
                        <p ><a href="lorganisme.html">L'organisme</a></p>
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
                        <p><a href="bottin.html">Bottin de ressources</a></p>
                    </li>
                    <li>
                        <p class="current"><a href="temoignages.html">Témoignages</a></p>
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
                <p style="color:<?=$couleur ?>"><?=$msg ?></p>
                <h2>Témoignages</h2>
                
                <?php
                    foreach($this->modele->getTemoignages() as $temoignage) {
                        echo "<div class='temoignage'>".$temoignage[0]."</div>";
                        echo "<div class='temoin'>".$temoignage[1]."</div><hr>";
                    }
                ?>
               
            </div>
        </section>
        </div>
    <footer>
    <p><a href="documents.html">Document à télécharger</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="contact.html">Contacter l'administration</a></p>
        <p>©Les Services de Crise de Lanaudière, 2017 <br><?=$parametres['creditFooter'] != 0?"<span>Conception par Cédrick Collin.</span>":"" ?></p>
    </footer>

</body>
</html>