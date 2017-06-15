<!doctype html>

<?php
/* -------------------------------------
| fichier gererEvenements.php
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
|   VUE : la page de gestion du contenu de la page événements
|------------------------------------- */

if($_SESSION['permission'] > 4) {
    header("location:index.php");
}

mb_internal_encoding('UTF-8');
$msg = "&nbsp;";
if(isset($_POST['ajoutEvenement'])){
    $nom=$_POST['titreEvenement'];
    $date=$_POST['date'];
    $description = $_POST['descriptionEvenement'];
    $this->modele->ajoutEvenement($nom, $date, $description);
    $msg = "L'ajout s'est bien effectué.";
}

if(isset($_POST['editEvenement'])) {
    $nom=$_POST['titreEvenement'];
    $date=$_POST['date'];
    $description = $_POST['descriptionEvenement'];
    $this->modele->editEvenement($nom, $date, $description, $_POST['evenementID']);
    $msg = "L'édition s'est bien effectué.";
}

if(isset($_GET['supprimer'])){
    $this->modele->deleteEvenement($_GET['evenementID']);
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
            plugins:['textcolor', 'colorpicker'],
            height: '400',
            toolbar1: "undo redo | forecolor backcolor ",
            
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
        <p style="font-size:1.7em;line-height:1.8em;"><?=isset($_GET['modifier'])? "Modifier":"Ajouter" ?> un Événement</p>
        <form id="formAjoutAdmin" class="collapsable" method="post" action="gererEvenements.html">
            <input type="text" name="titreEvenement" placeholder="Titre de l'événement" value="<?= isset($_GET['modifier'])? $this->modele->getEvenement($_GET['evenementID'])['nomEvenement'] : "" ?>" required/><br>
            <input type="datetime-local" name="date" placeholder="Témoin" value="<?= isset($_GET['modifier'])? $this->modele->getEvenement($_GET['evenementID'])['dateEvenement'] : "" ?>" required/><br>
            <textarea name="descriptionEvenement"><?= isset($_GET['modifier'])? $this->modele->getEvenement($_GET['evenementID'])['descriptionEvenement'] : "Description de l'événement" ?></textarea>
            <?=isset($_GET['modifier'])? "<input type='hidden' name='evenementID' value='".$_GET['evenementID']."' />":"" ?>
            <input type="submit" name="<?=isset($_GET['modifier'])? "editEvenement":"ajoutEvenement" ?>" value="<?=isset($_GET['modifier'])? "Modifier":"Ajouter" ?>" />
        </form>
    </div>
    <div id="right">
        <p style="font-size:1.7em;line-height:1.8em;">Gérer les événements</p>
        <div id="listeTemoignages">

        <?php
            foreach($this->modele->getEvenements() as $evenement){
                
                ?>
                <p ><span><?=$evenement['nomEvenement']?></span><span><?=$evenement['dateEvenement']?></span> <span><a href='gererEvenements.html?modifier&evenementID=<?=$evenement['evenementID']?>'><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
         width="528.899px" height="528.899px" viewBox="0 0 528.899 528.899" style="enable-background:new 0 0 528.899 528.899;"
         xml:space="preserve">
    <g>
        <path d="M328.883,89.125l107.59,107.589l-272.34,272.34L56.604,361.465L328.883,89.125z M518.113,63.177l-47.981-47.981
            c-18.543-18.543-48.653-18.543-67.259,0l-45.961,45.961l107.59,107.59l53.611-53.611
            C532.495,100.753,532.495,77.559,518.113,63.177z M0.3,512.69c-1.958,8.812,5.998,16.708,14.811,14.565l119.891-29.069
            L27.473,390.597L0.3,512.69z"/>
    </g>

    </svg>
    </a>  <a href='gererEvenements.html?supprimer&evenementID=<?=$evenement['evenementID']?>'><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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