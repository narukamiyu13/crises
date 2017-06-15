<!doctype html>

<?php
/* -------------------------------------
| fichier index.php
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
|   VUE : la page de connexion au panneau d'administration
|------------------------------------- */

$errMsg = "&nbsp;";
if(isset($_GET['err'])) {
    if(isset($_GET['8741'])){
        $errMsg .= "Vous devez entrer un nom d'utilisateur valide <br/>&nbsp;";
    }
    if(isset($_GET['1478'])){
        $errMsg .= "Vous devez entrer un mot de passe<br/>&nbsp;";
    }
    if(isset($_GET['5284'])){
        $errMsg .= "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
    <link rel="stylesheet" type="text/css" href="assets/fonts/fonts.css">
    <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
    <link rel="stylesheet" type="text/css" href="assets/style/style.php">
</head>
<body id="index">
    <img src="assets/images/logo.jpg" alt="Logo Services de crise de Lanaudière">
    <h2>Vous devez vous connecter pour continuer</h2>
    <p style="color:#C00;"><?=$errMsg ?></p>
    <form method="post" action="index.php">
        <input type="text" name="username" placeholder="nom d'utilisateur"/>
        <input type="password" name="password" placeholder="Mot de passe"/>
        <input type="submit" name="connexion" value="Connexion"/>
    </form>
</body>
</html>