<!doctype html>

<?php
/* -------------------------------------
| fichier gererPassword.php
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
|   VUE : la page de changement de mot de passe
|------------------------------------- */

$msg = "&nbsp;";
if(isset($_POST['continue'])){
    if(sha1($_POST['passActuel']) == $this->modele->getPassword($_SESSION['userID'])){
        header("location:gererPassword.html?step=2");
    }
}

if(isset($_POST['changer'])){
    $this->modele->updatePassword($_POST['nouveauPass'], $_SESSION['userID']);
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
            var passOK = false;
            $("#password").keyup(function(){
                var valActuelle = $(this).val();
                var secure = false;
                var superSecure = false;
                if(valActuelle.match(/[A-Z]/g) && valActuelle.match(/[0-9]/g) && valActuelle.length >=8){secure = true; passOK = true; $("#password").addClass("inputOk");} else {$("#password").removeClass("inputOk");}
                if((valActuelle.match(/[A-Z]/g) != null && valActuelle.match(/[A-Z]/g).length>=2) && (valActuelle.match(/[0-9]/g)!= null && valActuelle.match(/[0-9]/g).length>=2) && valActuelle.length >= 15) {superSecure = true, $("#password").addClass("inputOk");};
                console.log(secure+" "+superSecure);
            })
            
            $("#confirm").keyup(function(){
                if($(this).val() == $('#password').val()){
                    console.log("pareil");
                    if(passOK) {
                        $('#continuer').prop("disabled", false);
                        $("#confirm").addClass("inputOk")
                    }
                } else {
                    console.log("different");
                    $('#continuer').prop("disabled", true);
                     $("#confirm").removeClass("inputOk")
                }
            })
            
        })// FIN DOCUMENT.ready
        
    </script>
</head>
<body id="dashboard-password" class='dashboard gererPassword'>
    <img src="assets/images/logo.jpg" alt="Logo Services de crise de Lanaudière">
    <p class="previous"><a href='index.php'>&#x21E6</a></p>
    <h3>Bonjour, <?= $_SESSION['prenom'] ?></h3>
    <h2>Mettons à jour votre mot de passe</h2>
   
    <p><?=$msg?></p>
    <?php
    if(!isset($_GET['step']) || $_GET['step'] == 1){
    ?>
    <p>Afin de confirmer votre identité, entrez d'abord votre mot de passe actuel</p>
    <form method="post" action="gererPassword.html">
        <div class="input"><input type="password" name="passActuel" placeholder ="Mot de passe actuel" /></div>
        <input type="submit" name="continue" value="Continuer" />
    </form>
    <?php
    } else if($_GET['step'] == 2){
    ?>
    <p>Parfait. Choisissez à présent votre nouveau mot de passe. Il doit faire au moins 8 caractères, et comporter au moins 1 majuscule et 1 chiffre</p>
    <form method="post" action="gererPassword.html?step=success">
        <div class="input"><input type="password" id="password" name="nouveauPass" placeholder ="Nouveau mot de passe" /><span></span></div>
        <div class="input"><input type="password" id="confirm" name="confirmPass" placeholder ="Confirmer mot de passe" /><span></span></div>
        <input type="submit" id="continuer" name="changer" value="Confirmer" disabled/>
    </form>
    
      <?php
    } else  if($_GET['step'] == "success") {
        echo "<p>Votre mot de passe a été mis à jour avec succès.</p>";
    }
    ?>
</body>
</html>