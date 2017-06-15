<!doctype html>

<?php
/* -------------------------------------
| fichier accueilDashboard.php
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
|   VUE : L'accueil du panneau d'administration
|------------------------------------- */
$boutons = $this->modele->getBoutons($_SESSION['permission']);
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
        window.addEventListener("load",function(){
            var conteneurBoutons = document.querySelector("#conteneurEBoutons");
            var boutons =   <?= json_encode($boutons) ?>;
            var inCol = 0;
            var stringBoutons="";
            for(var i=0; i<boutons.length; i++) {
                console.log(inCol);
                if(inCol == 0) {
                    console.log("debutDIV");
                    stringBoutons+="<div style='float:left;width:325px;height:550px;'>";
                }
                console.log("BOUTON");
                stringBoutons+="<p class='dash-button'><a href='"+boutons[i][1]+"'>"+boutons[i][0]+"</a></p>";
                inCol++;
                if(inCol == 3) {
                    console.log("FINDIV");
                    stringBoutons+="</div>";
                    inCol = 0;
                }

            }
            conteneurBoutons.innerHTML=stringBoutons;
            
            var page =1,
                total =boutons.length,
                maxPages=Math.ceil(total/9),
                nextBT = document.querySelector(".next.pageContenu"),
                prevBT = document.querySelector(".previous.pageContenu"),
                curPage = document.querySelector("#curPage"),
                totPage = document.querySelector("#totPage");
            nextBT.addEventListener("click",changeNext);
            prevBT.addEventListener("click",changePrevious);
            curPage.innerHTML = page;
            totPage.innerHTML = maxPages;
            
            function changeNext(){
                if(page!=maxPages) {
                    var currentMargin = conteneurBoutons.style.marginLeft;
                    if(currentMargin=="") {currentMargin="0px";}
                    currentMargin = currentMargin.replace("px","");
                    currentMargin = parseInt(currentMargin);
                    var newMargin = currentMargin-975;
                    newMargin = newMargin.toString()+"px";
                    page++;
                    curPage.innerHTML = page;
                    conteneurBoutons.style.marginLeft=newMargin;
                }
            }
            
            function changePrevious(){
                if(page!=1) {
                    var currentMargin = conteneurBoutons.style.marginLeft;
                    if(currentMargin=="") {currentMargin="0px";}
                    currentMargin = currentMargin.replace("px","");
                    currentMargin = parseInt(currentMargin);
                    var newMargin = currentMargin+975;
                    newMargin = newMargin.toString()+"px";
                    page--;
                    curPage.innerHTML = page;
                    conteneurBoutons.style.marginLeft=newMargin;
                }
            }
            
            
            
        })
    </script>
</head>
<body id="dashboard-contenu" class='dashboard gererContenu'>
    <img src="assets/images/logo.jpg" alt="Logo Services de crise de Lanaudière">
    <h3>Bonjour, <?= $_SESSION['prenom'] ?></h3>
    <h2>Que voulez-vous faire aujourd'hui?</h2>
    <div class="previous pageContenu"><p>&#x21E6</p></div>
    <div id="conteneurBoutons">
       <div id="conteneurEBoutons">
        
    
    </div> 
    
    </div>
    <div class="next pageContenu"><p>&#x21E8</p></div>
    <p style="position:fixed;left:25px;top:500px;">Page:<br>
    <span id="curPage"></span><br>
    sur<br>
    <span id="totPage"></span></p>
    <p id="btDeconnexion" onclick="window.location='index.html?logout'">Déconnexion</p>
</body>
</html>