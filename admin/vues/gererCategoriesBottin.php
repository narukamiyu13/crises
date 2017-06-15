<!doctype html>

<?php
/* -------------------------------------
| fichier gererCategoriesBottin.php
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
|   VUE : la page de gestion des catégories de ressources du bottin
|------------------------------------- */

if($_SESSION['permission'] > 4) {
    header("location:index.php");
}

mb_internal_encoding('UTF-8');
$msg = "&nbsp;";
if(isset($_POST['ajoutCategorie'])){
    $nom=$_POST['titreEvenement'];
    $this->modele->ajoutCategorie($nom);
    $msg = "L'ajout s'est bien effectué.";
}



if(isset($_GET['supprimer'])){
    $this->modele->deleteCategorie($_GET['categorieID']);
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Panneau d'administration</title>
    <link rel="stylesheet" type="text/css" href="assets/fonts/fonts.css">
    <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
    <link rel="stylesheet" type="text/css" href="assets/style/style.php">
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
        $(document).ready(function(){
             $("#modalEdit").click(function(event){
                 if(event.target == $(this)[0]) {
                     $(this).hide();
                 }
            })
        });
   
    </script>
</head>
<body id="dashboard-admins" class='dashboard gererTemoignages'>
    <img src="assets/images/logo.jpg" alt="Logo Services de crise de Lanaudière">
    <p class="previous"><a href='index.php'>&#x21E6</a></p>
    <h3>Bonjour, <?= $_SESSION['prenom'] ?></h3>
    <h2>Quelle tâche voulez-vous effectuer?</h2>
   
    <p><?=$msg?></p>
    <div id="left">
        <p style="font-size:1.7em;line-height:1.8em;">Ajouter une catégorie</p>
        <form id="formAjoutAdmin" class="collapsable" method="post" action="gererCategoriesBottin.html">
            <input type="text" name="titreEvenement" placeholder="Titre de l'événement" v required/><br>
            <input type="submit" name="ajoutCategorie" value="Ajouter" />
        </form>
    </div>
    <div id="right">
        <p style="font-size:1.7em;line-height:1.8em;">Gérer les catégories</p>
        <div id="listeTemoignages">

        <?php
            foreach($this->modele->getCategories() as $categorie){
                
                ?>
                <p ><span style="width:60%;"><?=$categorie['nomCategorie']?></span><span style="width:125px;"> <a href='gererCategoriesBottin.html?supprimer&categorieID=<?=$categorie['categorieID']?>'><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
         width="900.5px" height="900.5px" viewBox="0 0 900.5 900.5" style="enable-background:new 0 0 900.5 900.5;" xml:space="preserve"
        >
    <g>
        <path d="M176.415,880.5c0,11.046,8.954,20,20,20h507.67c11.046,0,20-8.954,20-20V232.487h-547.67V880.5L176.415,880.5z
             M562.75,342.766h75v436.029h-75V342.766z M412.75,342.766h75v436.029h-75V342.766z M262.75,342.766h75v436.029h-75V342.766z"/>
        <path d="M618.825,91.911V20c0-11.046-8.954-20-20-20h-297.15c-11.046,0-20,8.954-20,20v71.911v12.5v12.5H141.874
            c-11.046,0-20,8.954-20,20v50.576c0,11.045,8.954,20,20,20h34.541h547.67h34.541c11.046,0,20-8.955,20-20v-50.576
            c0-11.046-8.954-20-20-20H618.825v-12.5V91.911z M543.825,112.799h-187.15v-8.389v-12.5V75h187.15v16.911v12.5V112.799z"/>
    </g>

    </svg></a></span></p>
            <?php
            }
        ?>
        </div>
    </div>
    
    
</body>
</html>