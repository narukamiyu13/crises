<!doctype html>

<?php
/* -------------------------------------
| fichier gererDons.php
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
|   VUE : la page de gestion du contenu de la page dons
|------------------------------------- */

$msg = "&nbsp;";
 setlocale(LC_ALL, 'fr_CA');
$parametres = $this->modele->getParametres();

if(isset($_POST['updateDons'])){
    try {
    $texte = $_POST['contenuDons'];
    
        $this->modele->setTexteDons($texte);
    header("location:gererDons.html?ok");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if(isset($_GET['ok'])){
    $msg = "Les changements ont bien été sauvegardés.";
}

$patterns = array('/January/i', '/February/i','/March/i','/April/i','/May/i','/June/i','/July/i','/August/i','/September/i','/October/i','/November/i','/December/i');
$remplacements = array('Janvier', 'Février','Mars', 'Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');

$date = utf8_encode(strftime("%e %B %Y %R", strtotime($this->modele->getTexteDons()['derniereModification'])));
$date = preg_replace($patterns,$remplacements, $date);
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Panneau d'administration</title>
    <link rel="stylesheet" type="text/css" href="assets/fonts/fonts.css">
    <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
    <link rel="stylesheet" type="text/css" href="assets/style/style.php">
    <link rel="stylesheet" type="text/css" href="assets/script/extensions/spectrum/spectrum.css" />
    <script src="assets/script/jquery-3.2.1.js"></script>
    <script src="assets/script/extensions/tinymce/tinymce.min.js"></script>
    <script>tinymce.init({ 
            selector:'textarea', 
            language:"fr_FR",
            plugins:['lists','link', 'lineheight', 'image', 'jbimages','imagetools', 'textcolor', 'colorpicker'],
            height: '400',
            toolbar1: "undo redo | styleselect | sizeselect | bold italic forecolor backcolor | fontselect fontsizeselect lineheightselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent  | link jbimages",
            fontsize_formats: "8pt 9pt 10pt 11pt 12pt 13pt 14pt 16pt 18pt 24pt 36pt",
            
            relative_urls: false
            
            });</script>
    <script>
        
    </script>
</head>
<body id="dashboard-parametres" class='dashboard gererServices'>
    <img src="assets/images/logo.jpg" alt="Logo Services de crise de Lanaudière">
    <p class="previous"><a href='index.php'>&#x21E6</a></p>
    <h3>Bonjour, <?= $_SESSION['prenom'] ?></h3>
    <h2>Modifier le texte de la section Dons</h2>
    <p style="margin-bottom:50px;"><?=$msg; ?></p>
    <?php if($_SESSION['permission'] <= 3) { ?>
    <p style="margin-bottom:20px;text-align:left;">Dernière Modification: le <?= $date ?> par <?=$this->modele->getTexteDons()['prenomAdmin']; ?> <?=$this->modele->getTexteDons()['nomAdmin']; ?></p>
    <?php } ?>
    <form method="post" action="gererDons.html">
        
        
        
    <textarea name="contenuDons"><?=$this->modele->getTexteDons()['texteDons']; ?></textarea>
        <input type="submit" name="updateDons" value="Accepter" />
    </form>
</body>
</html>