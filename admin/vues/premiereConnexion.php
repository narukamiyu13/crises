<!doctype html>
<?php
/* -------------------------------------
| fichier premiereConnexion.php
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
|   VUE : La page de mise à jour des informations de sécurité lors de la première connexion
|------------------------------------- */
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration - Premiere connexion</title>
    <script src="assets/script/jquery-3.2.1.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/fonts/fonts.css">
    <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
    <link rel="stylesheet" type="text/css" href="assets/style/style.php">
</head>
<body id="firstLogin">
    <img src="assets/images/logo.jpg" alt="Logo Services de crise de Lanaudière">
    <h2>Bonjour, <?=$_SESSION['prenom'] ?></h2>
    <p>Étant donné qu'il s'agit de votre première connexion, nous allons passer à travers quelques étapes avant de vous amener au panneau d'administration.</p>
    <?php if(!isset($_GET['step']) || $_GET['step'] == 1) { ?>
        <script>
        $(document).ready(function(){
            var passOK = false;
            $("#password").keyup(function(){
                var valActuelle = $(this).val();
                var secure = false;
                var superSecure = false;
                if(valActuelle.match(/[A-Z]/g) && valActuelle.match(/[0-9]/g) && valActuelle.length >=8){secure = true; passOK = true; $("#passwordOk").html("Le mot de passe est valide!");} else {$("#passwordOk").html("&nbsp");}
                if((valActuelle.match(/[A-Z]/g) != null && valActuelle.match(/[A-Z]/g).length>=2) && (valActuelle.match(/[0-9]/g)!= null && valActuelle.match(/[0-9]/g).length>=2) && valActuelle.length >= 15) {superSecure = true, $("#passwordOk").html("Le mot de passe est exceptionnel!");};
                console.log(secure+" "+superSecure);
            })
            
            $("#confirm").keyup(function(){
                if($(this).val() == $('#password').val()){
                    console.log("pareil");
                    if(passOK) {
                        $('#continuer').prop("disabled", false);
                        $("#passwordIdentiques").html("Les mots de passe sont identiques!")
                    }
                } else {
                    console.log("different");
                    $('#continuer').prop("disabled", true);
                     $("#passwordIdentiques").html("&nbsp;")
                }
            })
            
        })// FIN DOCUMENT.ready
        
    </script>
        <h3>D'abord, sélectionnez votre mot de passe.</h3>
        <p>Il doit comporter au moins 8 caractères, 1 nombre et 1 majuscule.</p>

        <form method="post" action="index.php?premierLogin&step=2">
            <input type="password" id='password' name="password" placeholder="Mot de passe">
            <span id="passwordOk" style="color:#00CC00;">&nbsp;</span><br/>
            <input type="password" id='confirm' name="confirmPassword" placeholder="Confirmer le mot de passe">
            <span id="passwordIdentiques" style="color:#00CC00;">&nbsp;</span> <br/>
            <input type="submit" name="goStep2" id="continuer" value="Continuer" disabled>
        </form>
    
    <?php } else if($_GET['step'] == 2){
            $password = sha1($_POST['password'])?>
        <script>
        $(document).ready(function(){
            function checkForm(){
                var formOk = Array();
                for(var i=1; i<=3; i++) {
                    if($("#question"+i).val() != null) formOk.push("Ok");
                    if($("#reponse"+i).val() != "") formOk.push("ok");
                }
                //console.log(formOk.length);
                if(formOk.length == 6) {
                    $("#terminer").prop("disabled", false);
                } else {
                    $("#terminer").prop("disabled", true);
                }
            }
            
            $("select").change(checkForm);
            $("input[type='text']").keyup(checkForm);
           
            
        })// FIN DOCUMENT.ready
        
    </script>
        <h3>Parfait. Choisissez maintenant vos questions de sécurité et entrez les réponses.</h3>
        <p>Ces questions seront nécessaires dans le cas où vous perdriez votre mot de passe.</p>
        <form method="post" action="index.php?premierLogin&step=merci">
            <select id="question1" name="question[]">
                <option selected hidden disabled>Sélectionnez une question</option>
                <?php foreach($this->modele->questionsSecurite() as $question) {
                        echo "<option value='".$question['questionID']."'>".$question['texteQuestion']."</option>";
                } ?>
            </select>
            <input type="text" id="reponse1" name="reponse[]" placeholder="Réponse..." />
            <hr>
            <select id="question2" name="question[]">
                <option selected hidden disabled>Sélectionnez une question</option>
                <?php foreach($this->modele->questionsSecurite() as $question) {
                        echo "<option value='".$question['questionID']."'>".$question['texteQuestion']."</option>";
                } ?>
            </select>
            <input type="text" id="reponse2" name="reponse[]" placeholder="Réponse..." />
            <hr>
            <select id="question3" name="question[]">
                <option selected hidden disabled>Sélectionnez une question</option>
                <?php foreach($this->modele->questionsSecurite() as $question) {
                        echo "<option value='".$question['questionID']."'>".$question['texteQuestion']."</option>";
                } ?>
            </select>
            <input type="text" id="reponse3" name="reponse[]" placeholder="Réponse..." />
            
            <input type="hidden" name="password" value="<?= $password ?>">
            <br/>
            <input type="submit" id="terminer" name="terminer" value="Compléter" disabled>
        </form>
    <?php } else if($_GET['step'] == "merci") {
                //var_dump($_POST['question']);
                //var_dump($_POST['reponse']);
            $this->modele->updateInfos($_SESSION['userID'],$_POST['password'],$_POST['question'],$_POST['reponse']);?>
    
  
        <h3>Félicitations!</h3>
        <p>Votre mot de passe est mis à jour, et votre configuration de sécurité effectuée. <a href="index.php">Aller au panneau d'administration</a></p>
      <?php } ?>
</body>
</html>