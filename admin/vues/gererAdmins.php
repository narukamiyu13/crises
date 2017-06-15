<!doctype html>

<?php
/* -------------------------------------
| fichier gererAdmins.php
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
|   VUE : la page de gestion des administrateurs
|------------------------------------- */

if($_SESSION['permission'] > 3) {
    header("location:index.php");
}

mb_internal_encoding('UTF-8');
$msg = "&nbsp;";
if(isset($_POST['ajoutAdmin'])){
    $username=mb_strtolower(mb_substr($_POST['prenom'],0,1).$_POST['nom']);
    $prenom = ucfirst(mb_strtolower($_POST['prenom']));
    $nom = ucfirst(mb_strtolower($_POST['nom']));
    $courriel = mb_strtolower($_POST['courriel']);
    $this->modele->ajoutAdmin($prenom,$nom,$username,$courriel,$_POST['niveauPermissions']);
    $msg = "L'ajout s'est bien effectué.";
}

if(isset($_POST['editAdmin'])) {
    $username=mb_strtolower(mb_substr($_POST['prenom'],0,1).$_POST['nom']);
    $prenom = ucfirst(mb_strtolower($_POST['prenom']));
    $nom = ucfirst(mb_strtolower($_POST['nom']));
    $courriel = mb_strtolower($_POST['courriel']);
    $this->modele->editAdmin($prenom,$nom,$courriel,$_POST['niveauPermissions'], $_POST['adminID']);
    $msg = "L'édition s'est bien effectué.";
}

if(isset($_GET['supprimer'])){
    $this->modele->deleteAdmin($_GET['adminID']);
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
<body id="dashboard-admins" class='dashboard gererAdmins'>
    <img src="assets/images/logo.jpg" alt="Logo Services de crise de Lanaudière">
    <p class="previous"><a href='index.php'>&#x21E6</a></p>
    <h3>Bonjour, <?= $_SESSION['prenom'] ?></h3>
    <h2>Quelle tâche voulez-vous effectuer?</h2>
   
    <p><?=$msg?></p>
    <p style="font-size:1.7em;line-height:1.8em;">Ajouter un Administrateur</p>
    <form id="formAjoutAdmin" class="collapsable" method="post" action="gererAdmins.html">
        <input type="text" name="prenom" placeholder="Prénom" required/>
        <input type="text" name="nom" placeholder="Nom" required/><br>
        <input type="text" name="courriel" placeholder="Couriel" required/>
        <select name="niveauPermissions" required>
            <option disabled hidden selected>Niveau de permissions</option>
        <?php
            foreach($this->modele->getPermissionsAjoutAdmin($_SESSION['permission']) as $option) {
                echo "<option value='".$option['niveauPermissionID']."'>".$option['nomNiveauPermission']."</option>";
            }
        ?>
        </select><br>
        <input type="submit" name="ajoutAdmin" value="Ajouter" />
    </form>
    
    <p style="font-size:1.7em;line-height:1.8em;margin-top:30px;">Gérer les administrateurs actuels</p>
    <div id="listeAdmins">
    
    <?php
        foreach($this->modele->getAdmins() as $admin){
            ?>
            <p ><span><?=$admin['prenomAdmin']?> <?=$admin['nomAdmin']?></span> - <span><?=$admin['nomNiveauPermission']?></span> <span><?=$admin['courrielAdmin']?></span> <span><a href='gererAdmins.html?modifier&adminID=<?=$admin['adminID']?>'><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="528.899px" height="528.899px" viewBox="0 0 528.899 528.899" style="enable-background:new 0 0 528.899 528.899;"
	 xml:space="preserve">
<g>
	<path d="M328.883,89.125l107.59,107.589l-272.34,272.34L56.604,361.465L328.883,89.125z M518.113,63.177l-47.981-47.981
		c-18.543-18.543-48.653-18.543-67.259,0l-45.961,45.961l107.59,107.59l53.611-53.611
		C532.495,100.753,532.495,77.559,518.113,63.177z M0.3,512.69c-1.958,8.812,5.998,16.708,14.811,14.565l119.891-29.069
		L27.473,390.597L0.3,512.69z"/>
</g>

</svg>
</a>  <a href='gererAdmins.html?supprimer&adminID=<?=$admin['adminID']?>'><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
    
    <?php
    if(isset($_GET['modifier'])){
        $ladmin = $this->modele->getUnAdmin($_GET['adminID']);
    ?>
    <div id="modalEdit">
        <div id="editModalContent">
            <h2>Modifier l'administrateur</h2>
            <form id="formEditAdmin" class="collapsable" method="post" action="gererAdmins.html">
                <input type="text" name="prenom" placeholder="Prénom" value="<?=$ladmin['prenomAdmin'] ?>"/>
                <input type="text" name="nom" placeholder="Nom" value="<?=$ladmin['nomAdmin'] ?>"/><br>
                <input type="text" name="courriel" placeholder="Couriel" value="<?=$ladmin['courrielAdmin'] ?>"/>
                <select name="niveauPermissions">
                <?php
                    foreach($this->modele->getPermissionsAjoutAdmin($_SESSION['permission']) as $option) {
                        echo "<option value='".$option['niveauPermissionID']."' ";
                        if($ladmin['permissionsAdmin'] == $option['niveauPermissionID']) echo "selected";
                        echo">".$option['nomNiveauPermission']."</option>";
                    }
                ?>
                </select><br>
                <input type="hidden" name="adminID" value="<?=$_GET['adminID'] ?>" />
                <input type="submit" name="editAdmin" value="Modifier" />
            </form>
        
        </div>
    </div>
    
    <?php
    }
    ?>
    
</body>
</html>