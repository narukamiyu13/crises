<!doctype html>

<?php
/* -------------------------------------
| fichier gererDocuments.php
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
|   VUE : la page de gestion du contenu des documents téléchargeables
|------------------------------------- */

if($_SESSION['permission'] > 4) {
    header("location:index.php");
}

mb_internal_encoding('UTF-8');
$msg = "&nbsp;";
if(isset($_POST['ajoutEvenement'])){
    $nom=$_POST['nomDocument'];
    $description = $_POST['descriptionEvenement'];
    $url = __DIR__."/../../assets/docs/".$_FILES['document']['name'];
    $urlBD= "assets/docs/".$_FILES['document']['name'];
    $this->modele->ajoutDocument($nom, $description, $urlBD);
    move_uploaded_file($_FILES['document']['tmp_name'],$url);
    //$this->modele->uploadDocument($_FILES['document']['tmp_name'],basename($_FILES['document']['name']));
    $msg = "L'ajout s'est bien effectué.";
}


if(isset($_GET['supprimer'])){
    $this->modele->deleteDocument($_GET['documentID']);
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
<body id="dashboard-admins" class='dashboard gererTemoignages gererDocuments'>
    <img src="assets/images/logo.jpg" alt="Logo Services de crise de Lanaudière">
    <p class="previous"><a href='index.php'>&#x21E6</a></p>
    <h3>Bonjour, <?= $_SESSION['prenom'] ?></h3>
    <h2>Quelle tâche voulez-vous effectuer?</h2>
   
    <p><?=$msg?></p>
    <div id="left">
        <p style="font-size:1.7em;line-height:1.8em;">Ajouter un Document</p>
        <form id="formAjoutAdmin" class="collapsable" method="post" action="gererDocuments.html" enctype="multipart/form-data">
            <input type="text" name="nomDocument" placeholder="Nom du Document" required/><br>
            <input type="file" name="document" id="input-document" required/><label for="input-document">Sélectionnez votre document</label><br>
            <textarea name="descriptionEvenement">Description du document</textarea>
            
            <input type="submit" name="ajoutEvenement" value="Ajouter" />
        </form>
    </div>
    <div id="right">
        <p style="font-size:1.7em;line-height:1.8em;">Gérer les documents</p>
        <div id="listeTemoignages">

        <?php
            foreach($this->modele->getDocuments() as $document){
                
                ?>
                <p ><span><?=$document['nomDocument']?></span><span> <?=$document['descriptionDocument']?></span> <span>  <a href='gererDocuments.html?supprimer&documentID=<?=$document['documentID']?>'><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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