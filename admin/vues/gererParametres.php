<!doctype html>

<?php
/* -------------------------------------
| fichier gererParametres.php
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
|   VUE : la page des Parametres du site
|------------------------------------- */

$msg = "&nbsp;";

$parametres = $this->modele->getParametres();

if(isset($_POST['updateParametres'])){
    if($_SESSION['permission']<=3){
        $cotisationsIdentiques = isset($_POST['cotisationsIdentiques'])? 1 :0;
        $creditPiedPage = isset($_POST['creditPiedPage'])? 1 :0;
        $cotisationAdhesion = $_POST['cotisationAdhesion'];
        $cotisationRenew = $_POST['cotisationRenew'];
        $couleurTheme = $_POST['couleurTheme'];
        $courrielAdjoint = $_POST['courrielAdjoint'];
        $courrielDirection = $_POST['courrielDirecteur'];
        $telephoneCrise = $_POST['telephoneCrise'];
        $telephoneAdministration = $_POST['telephoneAdmin'];
        $posteAdministration = $_POST['posteAdmin'];
        if(empty($posteAdministration)){$posteAdministration = NULL;}
        $adresse = $_POST['adresse'];
        $ville = $_POST['ville'];
        $codePostal = $_POST['codePostal'];
        
        $_SESSION['couleur'] = $couleurTheme;
        $this->modele->updateParametres($cotisationsIdentiques,$creditPiedPage,$cotisationAdhesion,$cotisationRenew,$couleurTheme,$courrielAdjoint,$courrielDirection,$telephoneCrise,$telephoneAdministration,$posteAdministration,$adresse,$ville,$codePostal);
        header("location:gererParametres.html?ok");
    } else {
        $couleurTheme = $_POST['couleurTheme'];
        $_SESSION['couleur'] = $couleurTheme;
        $this->modele->updateCouleur($couleurTheme);
        header("location:gererParametres.html?ok");
    }
}

if(isset($_GET['ok'])){
    $msg = "Les changements ont bien été sauvegardés.";
}

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
    <script src="assets/script/extensions/spectrum/spectrum.js"></script>
    <script>
        $(document).ready(function(){
             $("#cotisationsIdentiques").change(function(){
                 if(this.checked){
                     $("#cotisationRenew").attr("readonly", true);
                     $("#cotisationRenew").val($("#cotisationAdhesion").val());
                 } else {
                     $("#cotisationRenew").attr("readonly", false);
                 }
             })
            
            $("#couleurTheme").spectrum({
                color:"<?=$_SESSION['couleur'] ?>",
                showInput: true,
                preferredFormat: "hex"
            })
            
            $("#cotisationAdhesion").change(function(){
                if($("#cotisationsIdentiques").is(":checked")) {
                    console.log("je change les cotisations");
                    $("#cotisationRenew").val($(this).val());
                }
            })
            
            $(".pastille").click(function(){
                $("#couleurTheme").val($(this).data("color"));
                $("#couleurTheme").spectrum({
                color: $(this).data("color"),
                showInput: true,
                preferredFormat: "hex"
            })
            })
            
            
            $("#deleteAccount").click(function(){
                console.log("je montre")
                $("#modalDeleteConfirm").show();
            })
            
            $(".non").click(function(){
                $("#modalDeleteConfirm").hide();
            })
            
            $("#modalDeleteConfirm").click(function(evt){
                console.log(evt.target);
                if(evt.target == $(this)[0]){
                    $("#modalDeleteConfirm").hide();
                }
            })
            
            $(".oui").click(function(){
                window.location = "index.html?deleteAccount";  
            })
        
        });
    
    </script>
</head>
<body id="dashboard-parametres" class='dashboard gererParametres'>
    <img src="assets/images/logo.jpg" alt="Logo Services de crise de Lanaudière">
    <p class="previous"><a href='index.php'>&#x21E6</a></p>
    <h3>Bonjour, <?= $_SESSION['prenom'] ?></h3>
    <h2>Voici les paramètres actuels du site.</h2>
    
    <form method="post" action="gererParametres.html">
        <p><?= $msg; ?></p>
        <div id="param-Gauche">
            <?php if($_SESSION['permission'] <=3) {?>
            <div id="cotisation">
                <h4>Paramètres de cotisation</h4>
                <label class="switch">
                    <input type="checkbox" id="cotisationsIdentiques" name="cotisationsIdentiques"  <?= $parametres['cotisationsIdentiques']? "checked":"" ?>/>
                    <div class="slider"></div>
                </label>
                <p>Les cotisations d'adhésion et de renouvellement sont identiques</p><br>
                <label><input type="number" id="cotisationAdhesion" name="cotisationAdhesion" value="<?=$parametres['coutCotisationAdhesion'] ?>" step="any">$ Cotisation d'adhésion</label><br>
                <label><input type="number" id="cotisationRenew" name="cotisationRenew" value="<?=$parametres['coutCotisationRenouvellement'] ?>" step="any" <?= $parametres['cotisationsIdentiques']? "readonly":"" ?>/>$ Cotisation de renouvellement</label><br>
            </div>
            <div id="affichage">
                <h4>Paramètres d'affichage</h4>
                <label class="switch">
                    <input type="checkbox" id="creditPiedPage" name="creditPiedPage" <?= $parametres['creditFooter']? "checked":"" ?>>
                    <div class="slider"></div>
                </label>
                <p>Créditer le concepteur du site dans le pied de page</p>
            </div>
            <div id="coordonnees">
                <h4>Paramètres de coordonnées</h4>
                <p><label>Courriel Adjoint-e administratif<br>
                <input type="email" name="courrielAdjoint" value="<?=$parametres['courrielAdjoint'] ?>"/></label></p>
                <p><label>Courriel Directeur-trice<br>
                <input type="email" name="courrielDirecteur" value="<?=$parametres['courrielDirection'] ?>"/></label></p>
                <p><label>Téléphone ligne de crise<br>
                <input type="text" name="telephoneCrise" value="<?=$parametres['telephoneCrise'] ?>"/></label></p>
                <p><label>Téléphone administration<br>
                <input type="text" name="telephoneAdmin" value="<?=$parametres['telephoneAdministration'] ?>" /></label><br>
                poste (si applicable)<input type="text" name="posteAdmin" value="<?=$parametres['posteAdministration'] ?>" /></p>
                <p><label>Adresse Postale<br>
                <input type="text" name="adresse" value="<?=$parametres['adresse'] ?>"/></label></p>
                <p><label>Ville<br>
                <input type="text" name="ville" value="<?=$parametres['ville'] ?>"/></label></p>
                <p><label>Code Postal<br>
                <input type="text" name="codePostal" value="<?=$parametres['codePostal'] ?>"/></label></p>
                
            </div>
            <?php } ?>
            <div id="securite">
                <h4>Désactiver le compte</h4>
                <p>Vous pouvez en tout temps fermer votre compte d'administrateur en <span style="text-decoration:underline;cursor:pointer;" id="deleteAccount">cliquant ici</span>.</p>
            </div>
        </div>
        <div id="param-droite">
            <h4>Thème du panneau d'administration</h4>
            <div class="pastille" data-color="#A47102" style="background-color:#A47102;<?=$_SESSION['couleur'] == "#A47102"? "font-weight:bold;" : "" ?>">
                <p>Terre Brulée</p>
            </div>
            
            <div class="pastille" data-color="#FA7ABF" style="background-color:#FA7ABF;<?=$_SESSION['couleur'] == "#FA7ABF"? "font-weight:bold;" : "" ?>">
                <p>Barbe à papa</p>
            </div>
            
            <div class="pastille" data-color="#F1A61B" style="background-color:#F1A61B;<?=$_SESSION['couleur'] == "#F1A61B"? "font-weight:bold;" : "" ?>">
                <p>Tarte à la citrouille</p>
            </div>
            <div class="pastille" data-color="#13204E" style="background-color:#13204E;<?=$_SESSION['couleur'] == "#13204E"? "font-weight:bold;" : "" ?>">
                <p>Ténébreux</p>
            </div>
            
            <div class="pastille" data-color="#066467" style="background-color:#066467;<?=$_SESSION['couleur'] == "#066467"? "font-weight:bold;" : "" ?>">
                <p>Fleuve St-Laurent</p>
            </div>
            
            <div class="pastille" data-color="#0DBFB1" style="background-color:#0DBFB1;<?=$_SESSION['couleur'] == "#0DBFB1"? "font-weight:bold;" : "" ?>">
                <p>Bahamas</p>
            </div>
            <div class="pastille" data-color="#236723" style="background-color:#236723;<?=$_SESSION['couleur'] == "#236723"? "font-weight:bold;" : "" ?>">
                <p>Gazon Frais</p>
            </div>
            
            <div class="pastille" data-color="#7C7C7C" style="background-color:#7C7C7C;<?=$_SESSION['couleur'] == "#7C7C7C"? "font-weight:bold;" : "" ?>">
                <p>Acier Brossé</p>
            </div>
            
            <div class="pastille" data-color="#A47102" style="background-color:#A47102;<?php if($_SESSION['couleur'] != "#7C7C7C" &&$_SESSION['couleur'] != "#236723" &&$_SESSION['couleur'] != "#0DBFB1" &&$_SESSION['couleur'] != "#066467" &&$_SESSION['couleur'] != "#13204E" &&$_SESSION['couleur'] != "#F1A61B" &&$_SESSION['couleur'] != "#FA7ABF" &&$_SESSION['couleur'] != "#A47102") echo "font-weight:bold;"?>">
                <p>Personnalisé</p>
                
            </div><input type="text" name="couleurTheme" id="couleurTheme" value="<?= $_SESSION['couleur'] ?>">
        </div>
        <div style="clear:both"></div>
        <input type="submit" name="updateParametres" value="Accepter" />
    </form>
    
    
    <div id="modalDeleteConfirm">
        
        <div id="modaleDeleteContent">
            <p>Êtes-vous certain-e de vouloir désactiver votre compte?</p>
            
            <p class="btConfirm oui">Oui</p>
            <p class="btConfirm non">Non</p>
        
        </div>
    
    </div>
</body>
</html>